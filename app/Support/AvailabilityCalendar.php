<?php

namespace App\Support;

use App\Models\Property;
use App\Models\PropertyAvailability;
use Carbon\CarbonImmutable;

/**
 * Builds the 3-month availability grid shared by the public property
 * page and the host's interactive calendar.
 *
 * Both surfaces MUST agree on what a date looks like, so the shape is
 * built once here rather than twice in two controllers - otherwise a
 * host could block a date and see a different picture than a guest.
 *
 * DEFAULT IS AVAILABLE: property_availability only stores exceptions.
 * A date with no row is available, so a brand-new listing needs zero
 * rows to show a fully open calendar.
 */
class AvailabilityCalendar
{
    /** Current month + the next two. */
    public const MONTHS = 3;

    /**
     * @return list<array{key: string, label: string, leading: int, days: list<array<string, mixed>>}>
     */
    public static function build(Property $property, ?CarbonImmutable $today = null): array
    {
        $today = $today ? $today->startOfDay() : CarbonImmutable::today();
        $windowStart = $today->startOfMonth();
        $windowEnd = $windowStart->addMonths(self::MONTHS - 1)->endOfMonth();

        // One query for the whole window, keyed by Y-m-d so the per-day
        // loop below is a hash lookup rather than 90 queries.
        $records = $property->availability()
            ->whereBetween('calendar_date', [$windowStart->toDateString(), $windowEnd->toDateString()])
            ->get()
            ->keyBy(fn (PropertyAvailability $row) => $row->calendar_date->toDateString());

        $months = [];

        for ($monthOffset = 0; $monthOffset < self::MONTHS; $monthOffset++) {
            $monthStart = $windowStart->addMonths($monthOffset);
            $days = [];

            for ($dayOffset = 0; $dayOffset < $monthStart->daysInMonth; $dayOffset++) {
                $date = $monthStart->addDays($dayOffset);
                $key = $date->toDateString();

                /** @var PropertyAvailability|null $record */
                $record = $records->get($key);
                $status = $record->status ?? PropertyAvailability::STATUS_AVAILABLE;
                $source = $record->source ?? null;

                $days[] = [
                    'date'         => $key,
                    'day'          => $date->day,
                    'label'        => $date->format('j F Y'),
                    'status'       => $status,
                    'source'       => $source,
                    'is_past'      => $date->lt($today),
                    'is_available' => $status === PropertyAvailability::STATUS_AVAILABLE,
                    'is_locked'    => self::isLocked($status, $source),
                ];
            }

            $months[] = [
                'key'   => $monthStart->format('Y-m'),
                'label' => $monthStart->format('F Y'),
                // Blank cells before the 1st. dayOfWeek is 0 = Sunday,
                // matching the Su..Sa column order the views render.
                'leading' => (int) $monthStart->dayOfWeek,
                'days'    => $days,
            ];
        }

        return $months;
    }

    /**
     * Dates the host may not flip from their own calendar.
     *
     * - airbnb_sync: owned by the Airbnb feed. Letting a host clear it
     *   would double-book them, and the next sync would re-add it anyway.
     * - booked: flipping a booking back to "available" would silently
     *   discard the only record that the date is taken.
     */
    public static function isLocked(string $status, ?string $source): bool
    {
        return $source === PropertyAvailability::SOURCE_AIRBNB
            || $status === PropertyAvailability::STATUS_BOOKED;
    }
}
