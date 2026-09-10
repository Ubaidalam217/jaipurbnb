<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyAvailability;
use App\Services\ICalSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Covers the one-way Airbnb -> JaipurBnB calendar pull (ICalSyncService).
 *
 * The User-Agent test below is a REGRESSION GUARD, not a style preference.
 * Verified against the live Airbnb feed from the production host on
 * 2026-09-10: with Guzzle's default "GuzzleHttp/7" agent Airbnb answers
 * HTTP 429 on every request, while the identical URL from the same IP with
 * a browser agent answers 200. Dropping the header silently breaks every
 * Airbnb sync in production while all other tests still pass.
 */
class ICalSyncTest extends TestCase
{
    use RefreshDatabase;

    private const FEED_URL = 'https://www.airbnb.com/calendar/ical/123.ics?t=abc';

    /** A feed shaped exactly like the real Airbnb one: all-day, exclusive DTEND. */
    private function feed(string $dtstart, string $dtend): string
    {
        return implode("\r\n", [
            'BEGIN:VCALENDAR',
            'PRODID:-//Airbnb Inc//Hosting Calendar 1.0//EN',
            'CALSCALE:GREGORIAN',
            'VERSION:2.0',
            'BEGIN:VEVENT',
            'DTSTART;VALUE=DATE:'.$dtstart,
            'DTEND;VALUE=DATE:'.$dtend,
            'SUMMARY:Airbnb (Not available)',
            'UID:7f662ec65913@airbnb.com',
            'END:VEVENT',
            'END:VCALENDAR',
        ]);
    }

    private function propertyWithFeed(): Property
    {
        return Property::factory()->live()->create(['ical_feed_url' => self::FEED_URL]);
    }

    public function test_it_sends_a_browser_user_agent_so_airbnb_does_not_answer_429(): void
    {
        Http::fake([self::FEED_URL => Http::response($this->feed('20270910', '20270911'))]);

        app(ICalSyncService::class)->syncProperty($this->propertyWithFeed());

        Http::assertSent(function (Request $request) {
            $agent = $request->header('User-Agent')[0] ?? '';

            $this->assertStringContainsString('Mozilla/5.0', $agent);
            $this->assertStringNotContainsString('Guzzle', $agent);

            return true;
        });
    }

    public function test_it_blocks_the_nights_a_booking_covers(): void
    {
        // 5th to 7th = nights of the 5th and 6th; the 7th is checkout day.
        Http::fake([self::FEED_URL => Http::response($this->feed('20261105', '20261107'))]);

        $property = $this->propertyWithFeed();
        $result = app(ICalSyncService::class)->syncProperty($property);

        $this->assertTrue($result['synced']);
        $this->assertSame(2, $result['blocked']);

        $dates = $property->availability()->orderBy('calendar_date')->pluck('calendar_date')
            ->map(fn ($d) => $d instanceof \DateTimeInterface ? $d->format('Y-m-d') : (string) $d)
            ->all();

        $this->assertSame(['2026-11-05', '2026-11-06'], $dates);
        $this->assertSame(
            PropertyAvailability::SOURCE_AIRBNB,
            $property->availability()->first()->source
        );
    }

    public function test_a_429_is_reported_as_a_failure_and_blocks_nothing(): void
    {
        Http::fake([self::FEED_URL => Http::response('rate limited', 429)]);

        $property = $this->propertyWithFeed();
        $result = app(ICalSyncService::class)->syncProperty($property);

        $this->assertFalse($result['synced']);
        $this->assertStringContainsString('429', $result['reason']);
        $this->assertSame(0, $property->availability()->count());
    }

    public function test_it_never_overwrites_a_date_the_host_blocked_manually(): void
    {
        Http::fake([self::FEED_URL => Http::response($this->feed('20261105', '20261106'))]);

        $property = $this->propertyWithFeed();
        $property->availability()->create([
            'calendar_date' => '2026-11-05',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);

        app(ICalSyncService::class)->syncProperty($property);

        $this->assertSame(
            PropertyAvailability::SOURCE_MANUAL,
            $property->availability()->whereDate('calendar_date', '2026-11-05')->first()->source
        );
    }

    public function test_a_cancelled_booking_frees_the_date_again(): void
    {
        $property = $this->propertyWithFeed();
        $property->availability()->create([
            'calendar_date' => '2026-11-05',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_AIRBNB,
        ]);

        // The feed no longer lists the 5th - the booking went away.
        Http::fake([self::FEED_URL => Http::response($this->feed('20261120', '20261121'))]);

        $result = app(ICalSyncService::class)->syncProperty($property);

        $this->assertSame(1, $result['removed']);
        $this->assertSame(0, $property->availability()->whereDate('calendar_date', '2026-11-05')->count());
    }

    public function test_one_dead_feed_does_not_abort_the_whole_run(): void
    {
        $dead = Property::factory()->live()->create(['ical_feed_url' => 'https://dead.test/a.ics']);
        $good = $this->propertyWithFeed();

        Http::fake([
            'dead.test/*' => Http::response('nope', 500),
            self::FEED_URL => Http::response($this->feed('20261105', '20261106')),
        ]);

        $totals = app(ICalSyncService::class)->syncAll();

        $this->assertSame(2, $totals['properties']);
        $this->assertSame(1, $totals['succeeded']);
        $this->assertSame(1, $totals['failed']);
        $this->assertSame(1, $good->availability()->count());
        $this->assertSame(0, $dead->availability()->count());
    }

    /**
     * Same constraint as the expiry sweep: Hostinger disables proc_open, so
     * the 30-minute sync must be registered via Schedule::call(), not
     * Schedule::command() - a callback event has a null ->command, so the
     * name given at registration lands in ->description.
     */
    public function test_the_thirty_minute_schedule_is_registered(): void
    {
        $events = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events())
            ->filter(fn ($event) => str_contains($event->description ?? '', 'ical:sync'));

        $this->assertCount(1, $events, 'ical:sync is not scheduled.');
        $this->assertSame('*/30 * * * *', $events->first()->expression);
    }
}
