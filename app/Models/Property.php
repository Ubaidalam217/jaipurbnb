<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
    ];

    /**
     * The 22 filterable Jaipur neighborhoods, in the order given in
     * CLAUDE.md (roughly centre-out, then the outlying towns) - NOT
     * alphabetical. The browse filter renders this order verbatim.
     *
     * The three "... Road" entries are stored without CLAUDE.md's
     * parenthetical landmarks: 'Delhi Road', not
     * 'Delhi Road (Kukas/Achrol)'. Changing that would invalidate the
     * neighborhood already saved on every existing listing.
     */
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
        'Pratap Nagar',
        'Chitrakoot',
        'Sitapura',
        'Tonk Road',
        'Sanganer',
        'Jhotwara',
        'Delhi Road',
        'Ajmer Road',
        'Agra Road',
        'Chomu',
        'Bagru',
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
        'max_guests',
        'bedrooms',
        'bathrooms',
        'is_verified',
        'is_visible',
        'listing_status',
        'subscription_expiry',
        'verification_doc_url',
        'ical_feed_url',
        'rejection_reason',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_verified'         => 'boolean',
            'is_visible'          => 'boolean',
            'subscription_expiry' => 'date',
            'approx_price'        => 'integer',
            'max_guests'          => 'integer',
            'bedrooms'            => 'integer',
            'bathrooms'           => 'integer',
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

    /**
     * Pre-filled wa.me link, or null if the host has no usable phone
     * number. Uses urlencode() (not rawurlencode()) deliberately: wa.me
     * expects the classic application/x-www-form-urlencoded style,
     * where a space becomes "+" rather than "%20".
     *
     * Access via $property->host->cleanPhoneNumber() assumes 'host' is
     * loaded - every caller of this method already eager-loads it.
     */
    public function whatsappUrl(): ?string
    {
        $phone = $this->host->cleanPhoneNumber();

        if (! $phone) {
            return null;
        }

        $message = "Hi, I am interested in {$this->title} listed on JaipurBnB. Can you share more details?";

        return 'https://wa.me/91'.$phone.'?text='.urlencode($message);
    }

    /**
     * tel: link for the host's phone, or null if none is on file.
     */
    public function callUrl(): ?string
    {
        $phone = $this->host->cleanPhoneNumber();

        return $phone ? 'tel:+91'.$phone : null;
    }
}
