<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A Razorpay subscription payment made by a host.
 *
 * payment_status is a plain string column (no DB-level ENUM, for
 * SQLite+MySQL portability). Validate against self::STATUSES.
 *
 * property_id is nullable - a host may pay before the listing row
 * exists, and deleting a property nulls this rather than destroying
 * the payment record.
 *
 * paid_at is nullable: 'pending' and 'failed' transactions have no
 * settlement time yet.
 *
 * refund_reason is filled by the admin when a listing is rejected and
 * enters the manual Razorpay refund queue.
 *
 * DURATION_PRICES is the confirmed price list (CLAUDE.md): the amount
 * charged must be validated against it server-side - never trust a
 * price submitted by the client.
 */
class Transaction extends Model
{
    public const STATUS_PENDING  = 'pending';
    public const STATUS_SUCCESS  = 'success';
    public const STATUS_FAILED   = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_SUCCESS,
        self::STATUS_FAILED,
        self::STATUS_REFUNDED,
    ];

    public const DURATION_30  = 30;
    public const DURATION_90  = 90;
    public const DURATION_365 = 365;

    public const DURATIONS = [
        self::DURATION_30,
        self::DURATION_90,
        self::DURATION_365,
    ];

    public const PRICE_30  = 799;
    public const PRICE_90  = 1999;
    public const PRICE_365 = 5999;

    public const DURATION_PRICES = [
        self::DURATION_30  => self::PRICE_30,
        self::DURATION_90  => self::PRICE_90,
        self::DURATION_365 => self::PRICE_365,
    ];

    /** @var list<string> */
    protected $fillable = [
        'host_id',
        'property_id',
        'gateway_payment_id',
        'pack_duration_days',
        'amount_paid',
        'payment_status',
        'refund_reason',
        'paid_at',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'amount_paid'        => 'decimal:2',
            'paid_at'            => 'datetime',
            'pack_duration_days' => 'integer',
        ];
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
