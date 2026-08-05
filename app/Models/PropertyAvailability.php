<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One calendar day of availability for one property.
 *
 * $table is set explicitly: Eloquent would otherwise pluralise this
 * class to "property_availabilities", which is not the table name.
 *
 * status / source are plain string columns (no DB-level ENUM, for
 * SQLite+MySQL portability). Validate against the constants below.
 *
 * source distinguishes host-set blocks from dates pulled in by the
 * Milestone 3 Airbnb iCal sync, so a re-sync can safely replace only
 * its own rows without wiping manual blocks.
 */
class PropertyAvailability extends Model
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_BLOCKED   = 'blocked';
    public const STATUS_BOOKED    = 'booked';

    public const STATUSES = [
        self::STATUS_AVAILABLE,
        self::STATUS_BLOCKED,
        self::STATUS_BOOKED,
    ];

    public const SOURCE_MANUAL = 'manual';
    public const SOURCE_AIRBNB = 'airbnb_sync';

    public const SOURCES = [
        self::SOURCE_MANUAL,
        self::SOURCE_AIRBNB,
    ];

    protected $table = 'property_availability';

    /** @var list<string> */
    protected $fillable = [
        'property_id',
        'calendar_date',
        'status',
        'source',
    ];

    /**
     * calendar_date is stored as a bare Y-m-d string and read back as a
     * CarbonImmutable at midnight.
     *
     * This is a hand-rolled mutator rather than a `'calendar_date' => 'date'`
     * cast on purpose. That cast writes through Eloquent's datetime
     * formatter, which produces 'Y-m-d 00:00:00' - so a lookup by the
     * plain date ('2026-08-13') never matched the stored value, every
     * "find or create this day" turned into an INSERT, and the
     * unique(property_id, calendar_date) index rejected it. Storing a
     * true date keeps that index usable, which the Airbnb iCal sync
     * depends on for its per-day upsert.
     */
    protected function calendarDate(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value === null ? null : CarbonImmutable::parse($value)->startOfDay(),
            set: fn ($value) => $value instanceof \DateTimeInterface
                ? $value->format('Y-m-d')
                : CarbonImmutable::parse($value)->toDateString(),
        );
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
