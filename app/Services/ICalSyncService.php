<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyAvailability;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Sabre\VObject\Component\VCalendar;
use Sabre\VObject\Reader;
use Throwable;

/**
 * One-way Airbnb -> JaipurBnB calendar sync.
 *
 * Pulls each listing's .ics feed and blocks the dates it contains. We never
 * push anything back to Airbnb; their calendar is the authority for dates it
 * owns, ours is the authority for everything else.
 *
 * OWNERSHIP RULES - what the sync may and may not touch:
 *
 *   - It only ever writes rows with source = 'airbnb_sync'.
 *   - It never overwrites a 'manual' row. If a host has blocked a date
 *     themselves and Airbnb also has it, the host's row stays. The date is
 *     blocked either way, so the guest sees the same thing - but the host's
 *     intent survives the booking being cancelled later.
 *   - It never touches a 'booked' row, which is stronger than either.
 *   - Stale rows ARE removed: a future date previously pulled from the feed
 *     but no longer in it means the Airbnb booking was cancelled, so the
 *     date opens back up. Without this a cancelled booking would block the
 *     date forever.
 *
 * PAST DATES are skipped entirely - rewriting history serves nobody and
 * would churn rows on every run.
 *
 * FAILURE IS PER-PROPERTY. A dead URL, a timeout or a malformed .ics logs
 * and moves on; one bad feed must never abort the whole scheduled run.
 */
class ICalSyncService
{
    /** How far ahead to sync. The public calendar only shows 3 months, but
     *  Airbnb bookings land further out and we want them already stored. */
    public const HORIZON_MONTHS = 12;

    /** Feeds are external and occasionally slow; do not hang the scheduler. */
    public const TIMEOUT_SECONDS = 20;

    /** Airbnb feeds are small. Anything enormous is a wrong URL. */
    public const MAX_BYTES = 5_242_880; // 5 MB

    /**
     * Sync one listing.
     *
     * @return array{synced: bool, blocked: int, removed: int, reason: ?string}
     */
    public function syncProperty(Property $property, ?CarbonImmutable $today = null): array
    {
        $today = $today ? $today->startOfDay() : CarbonImmutable::today();

        if (blank($property->ical_feed_url)) {
            // The host disconnected the feed. Release the future dates it
            // used to own, otherwise a stale block outlives the connection
            // and the host can never clear it - isLocked() stops them
            // touching airbnb_sync rows from their own calendar.
            $removed = $this->releaseAirbnbDates($property, $today);

            if ($removed > 0) {
                Log::info('iCal sync: feed removed, released its dates', [
                    'property_id' => $property->id,
                    'removed'     => $removed,
                ]);
            }

            return $this->result(false, 0, $removed, 'no feed url');
        }

        try {
            $body = $this->fetch($property->ical_feed_url);
        } catch (Throwable $e) {
            Log::warning('iCal sync: could not fetch feed', [
                'property_id' => $property->id,
                'url'         => $property->ical_feed_url,
                'error'       => $e->getMessage(),
            ]);

            return $this->result(false, 0, 0, 'fetch failed: '.$e->getMessage());
        }

        try {
            $dates = $this->extractDates($body, $today);
        } catch (Throwable $e) {
            Log::warning('iCal sync: could not parse feed', [
                'property_id' => $property->id,
                'error'       => $e->getMessage(),
            ]);

            return $this->result(false, 0, 0, 'parse failed: '.$e->getMessage());
        }

        [$blocked, $removed] = $this->applyDates($property, $dates, $today);

        Log::info('iCal sync: property synced', [
            'property_id' => $property->id,
            'dates_in_feed' => count($dates),
            'blocked'     => $blocked,
            'removed'     => $removed,
        ]);

        return $this->result(true, $blocked, $removed, null);
    }

    /**
     * Sync every listing that has a feed configured.
     *
     * @return array{properties: int, succeeded: int, failed: int, blocked: int, removed: int}
     */
    public function syncAll(?CarbonImmutable $today = null): array
    {
        $totals = ['properties' => 0, 'succeeded' => 0, 'failed' => 0, 'blocked' => 0, 'removed' => 0];

        // Listings with a feed, PLUS any that still carry airbnb_sync rows
        // after their feed was removed - those need their dates released.
        Property::query()
            ->where(function ($query) {
                $query
                    ->where(fn ($q) => $q->whereNotNull('ical_feed_url')->where('ical_feed_url', '!=', ''))
                    ->orWhereHas('availability', fn ($q) => $q->where('source', PropertyAvailability::SOURCE_AIRBNB));
            })
            ->orderBy('id')
            ->chunkById(50, function ($properties) use (&$totals, $today) {
                foreach ($properties as $property) {
                    $totals['properties']++;

                    // Belt and braces: syncProperty already catches fetch and
                    // parse failures, but an unexpected error must not abort
                    // the remaining listings either.
                    try {
                        $result = $this->syncProperty($property, $today);
                    } catch (Throwable $e) {
                        Log::error('iCal sync: unexpected failure', [
                            'property_id' => $property->id,
                            'error'       => $e->getMessage(),
                        ]);
                        $totals['failed']++;

                        continue;
                    }

                    $result['synced'] ? $totals['succeeded']++ : $totals['failed']++;
                    $totals['blocked'] += $result['blocked'];
                    $totals['removed'] += $result['removed'];
                }
            });

        Log::info('iCal sync: run complete', $totals);

        return $totals;
    }

    /* ------------------------------------------------------------------ */

    private function fetch(string $url): string
    {
        $response = Http::timeout(self::TIMEOUT_SECONDS)
            ->connectTimeout(10)
            ->retry(2, 500, throw: false)
            ->withHeaders(['Accept' => 'text/calendar, text/plain, */*'])
            ->get($url);

        if (! $response->successful()) {
            throw new \RuntimeException('HTTP '.$response->status());
        }

        $body = $response->body();

        if ($body === '') {
            throw new \RuntimeException('empty response');
        }

        if (strlen($body) > self::MAX_BYTES) {
            throw new \RuntimeException('feed larger than '.self::MAX_BYTES.' bytes');
        }

        return $body;
    }

    /**
     * Every future Y-m-d covered by a VEVENT in the feed.
     *
     * @return list<string>
     */
    private function extractDates(string $body, CarbonImmutable $today): array
    {
        /** @var VCalendar $calendar */
        $calendar = Reader::read($body, Reader::OPTION_FORGIVING);

        $horizonEnd = $today->addMonths(self::HORIZON_MONTHS)->endOfMonth();

        // Expand recurrence rules into concrete instances. Airbnb feeds are
        // plain non-recurring blocks, but a host may paste a Google Calendar
        // URL, and those do use RRULE - without expanding, a weekly booking
        // would only block its first occurrence.
        try {
            $calendar = $calendar->expand(
                new \DateTime($today->toDateString()),
                new \DateTime($horizonEnd->toDateString())
            );
        } catch (Throwable $e) {
            // Not fatal: fall back to the unexpanded calendar so plain,
            // non-recurring events (the Airbnb case) still sync.
            Log::debug('iCal sync: expand() failed, using raw events', ['error' => $e->getMessage()]);
        }

        $dates = [];

        foreach ($calendar->VEVENT ?? [] as $event) {
            if (! isset($event->DTSTART)) {
                continue;
            }

            $start = CarbonImmutable::instance($event->DTSTART->getDateTime())->startOfDay();

            // DTEND is EXCLUSIVE for all-day events - an Airbnb booking of
            // the 5th to the 7th means nights of the 5th and 6th, checkout on
            // the 7th. Treating it as inclusive would block one night too
            // many on every single booking.
            if (isset($event->DTEND)) {
                $end = CarbonImmutable::instance($event->DTEND->getDateTime())->startOfDay()->subDay();
            } elseif (isset($event->DURATION)) {
                $end = $start->add($event->DURATION->getDateInterval())->subDay();
            } else {
                // No end at all: a single-day block.
                $end = $start;
            }

            if ($end->lt($start)) {
                $end = $start;
            }

            for ($date = $start; $date->lte($end); $date = $date->addDay()) {
                if ($date->lt($today) || $date->gt($horizonEnd)) {
                    continue;   // never rewrite the past, never run away into the future
                }

                $dates[$date->toDateString()] = true;
            }
        }

        return array_keys($dates);
    }

    /**
     * Write the feed's dates and drop the ones it no longer contains.
     *
     * @param  list<string>  $dates
     * @return array{0: int, 1: int}  [blocked, removed]
     */
    private function applyDates(Property $property, array $dates, CarbonImmutable $today): array
    {
        return DB::transaction(function () use ($property, $dates, $today) {
            $horizonEnd = $today->addMonths(self::HORIZON_MONTHS)->endOfMonth()->toDateString();

            // Rows the host or a booking owns. We must not convert these to
            // airbnb_sync, or a later cancellation would delete a block the
            // host set deliberately.
            $protected = $property->availability()
                ->where('calendar_date', '>=', $today->toDateString())
                ->where('source', '!=', PropertyAvailability::SOURCE_AIRBNB)
                ->pluck('calendar_date')
                ->map(fn ($d) => $d instanceof \DateTimeInterface ? $d->format('Y-m-d') : (string) $d)
                ->all();

            $writable = array_values(array_diff($dates, $protected));

            $blocked = 0;

            foreach ($writable as $date) {
                $row = $property->availability()->firstOrNew(['calendar_date' => $date]);

                $row->status = PropertyAvailability::STATUS_BLOCKED;
                $row->source = PropertyAvailability::SOURCE_AIRBNB;

                if ($row->isDirty() || ! $row->exists) {
                    $row->save();
                    $blocked++;
                }
            }

            // Anything we previously pulled in, still in the future and inside
            // the horizon, that the feed no longer lists = cancelled booking.
            $removed = $property->availability()
                ->where('source', PropertyAvailability::SOURCE_AIRBNB)
                ->where('calendar_date', '>=', $today->toDateString())
                ->where('calendar_date', '<=', $horizonEnd)
                ->when($dates !== [], fn ($q) => $q->whereNotIn('calendar_date', $dates))
                ->delete();

            return [$blocked, $removed];
        });
    }

    /**
     * Drop every future date this feed owns. Used when a host disconnects
     * their calendar - manual and booked rows are untouched.
     */
    private function releaseAirbnbDates(Property $property, CarbonImmutable $today): int
    {
        return $property->availability()
            ->where('source', PropertyAvailability::SOURCE_AIRBNB)
            ->where('calendar_date', '>=', $today->toDateString())
            ->delete();
    }

    /**
     * @return array{synced: bool, blocked: int, removed: int, reason: ?string}
     */
    private function result(bool $synced, int $blocked, int $removed, ?string $reason): array
    {
        return compact('synced', 'blocked', 'removed', 'reason');
    }
}
