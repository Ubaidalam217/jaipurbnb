<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * A JaipurBnB property listing.
 *
 * listing_status and is_visible are two INDEPENDENT axes:
 *   listing_status = admin moderation (pending | approved | rejected)
 *   is_visible     = live-on-site flag, set false by the daily expiry
 *                    cron once subscription_expiry has passed.
 * An expired listing stays 'approved' but becomes is_visible = false.
 *
 * listing_status / neighborhood / stay_type are plain string columns
 * (no DB-level ENUM, for SQLite+MySQL portability). The constants below
 * are the single source of truth - validate against them in every
 * FormRequest that writes this model.
 */
class Property extends Model
{
    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
    ];

    public const NEIGHBORHOODS = [
        'Walled City',
        'Amer',
        'Nahargarh',
        'C-Scheme',
        'Civil Lines',
        'Bani Park',
        'Vaishali Nagar',
        'Mansarovar',
        'Malviya Nagar',
        'Jagatpura',
        'Raja Park',
        'Sitapura',
        'Tonk Road',
        'Sanganer',
        'Delhi Road',
        'Ajmer Road',
        'Agra Road',
    ];

    public const STAY_TYPES = [
        'Heritage Haveli / Fort Stay',
        'Boutique Apartment',
        'Luxury Villa / Farmhouse',
        'Homestay / Guest House',
        'Backpacker Hostel',
    ];

    /** @var list<string> */
    protected $fillable = [
        'host_id',
        'title',
        'description',
        'neighborhood',
        'stay_type',
        'approx_price',
        'is_verified',
        'is_visible',
        'listing_status',
        'subscription_expiry',
        'verification_doc_url',
        'ical_feed_url',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_verified'         => 'boolean',
            'is_visible'          => 'boolean',
            'subscription_expiry' => 'date',
            'approx_price'        => 'integer',
        ];
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function availability(): HasMany
    {
        return $this->hasMany(PropertyAvailability::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(LeadAnalytic::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(PropertyImage::class)->where('is_cover', true);
    }
}
