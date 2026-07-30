<?php

namespace App\Models;

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

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'calendar_date' => 'date',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
