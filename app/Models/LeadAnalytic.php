<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Append-only lead event log powering the host dashboard counters.
 *
 * $table is set explicitly because Eloquent would singularise this
 * class to "lead_analytics" only by luck of the irregular plural -
 * being explicit avoids depending on that.
 *
 * $timestamps is false: this table has no created_at/updated_at.
 * clicked_at is the single event timestamp and defaults to
 * CURRENT_TIMESTAMP at the database level, so it may be omitted on
 * insert.
 *
 * lead_type is a plain string column (no DB-level ENUM). Validate
 * against self::TYPES.
 */
class LeadAnalytic extends Model
{
    public const TYPE_WHATSAPP     = 'whatsapp_click';
    public const TYPE_CALL         = 'call_click';
    public const TYPE_PROFILE_VIEW = 'profile_view';

    public const TYPES = [
        self::TYPE_WHATSAPP,
        self::TYPE_CALL,
        self::TYPE_PROFILE_VIEW,
    ];

    protected $table = 'lead_analytics';

    public $timestamps = false;

    /** @var list<string> */
    protected $fillable = [
        'property_id',
        'lead_type',
        'clicked_at',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'clicked_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
