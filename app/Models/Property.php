<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'max_adults',
        'max_children',
        'max_infants',
        'bedrooms',
        'bathrooms',
        'is_verified',
        'is_visible',
        'is_pet_friendly',
        'listing_status',
        'subscription_expiry',
        'verification_doc_url',
        'ical_feed_url',
        'rejection_reason',
        'latitude',
        'longitude',
        'full_address',
        'city',
        'state',
        'pincode',
        'is_demo',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_verified'         => 'boolean',
            'is_visible'          => 'boolean',
            'is_pet_friendly'     => 'boolean',
            'is_demo'             => 'boolean',
            'subscription_expiry' => 'date',
            'approx_price'        => 'integer',
            'max_guests'          => 'integer',
            'max_adults'          => 'integer',
            'max_children'        => 'integer',
            'max_infants'         => 'integer',
            'bedrooms'            => 'integer',
            'bathrooms'           => 'integer',
            'latitude'            => 'decimal:8',
            'longitude'           => 'decimal:8',
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

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }

    /**
     * Whether this listing has coordinates to put on a map. Both columns
     * are nullable and only ever set together (see PropertyStoreRequest),
     * but checking both keeps a half-filled row from rendering a broken
     * embed.
     */
    public function hasCoordinates(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    /**
     * How far either side of the pin the embedded map should reach, in
     * degrees. At Jaipur's latitude 0.008 deg is roughly 900m of latitude and
     * 800m of longitude, so the frame shows the surrounding neighbourhood
     * rather than an unreadable patch of rooftops.
     */
    private const MAP_SPAN = 0.008;

    /**
     * Embeddable map URL for this listing, or null if it has no coordinates.
     *
     * OpenStreetMap, NOT Google Maps. The previous
     * `maps.google.com/maps?q=...&output=embed` URL is an undocumented
     * endpoint that now answers 301 with `X-Frame-Options: SAMEORIGIN`, and a
     * browser enforces that header on the redirect response, so the iframe was
     * blocked and every listing showed an empty panel. Google's supported
     * alternative is the Maps Embed API, which requires an API key and a
     * billing account. OSM's export embed needs neither and sends no
     * frame-blocking headers.
     *
     * bbox order is min-longitude, min-latitude, max-longitude, max-latitude -
     * longitude FIRST, which is the opposite order from the marker parameter
     * immediately after it. Getting that backwards silently lands the map in
     * the wrong hemisphere rather than erroring.
     */
    public function mapEmbedUrl(): ?string
    {
        if (! $this->hasCoordinates()) {
            return null;
        }

        // Cast away the decimal:8 string form before doing arithmetic.
        $lat = (float) $this->latitude;
        $lon = (float) $this->longitude;

        return 'https://www.openstreetmap.org/export/embed.html?'.http_build_query([
            'bbox' => implode(',', [
                $lon - self::MAP_SPAN,
                $lat - self::MAP_SPAN,
                $lon + self::MAP_SPAN,
                $lat + self::MAP_SPAN,
            ]),
            'layer'  => 'mapnik',
            'marker' => $lat.','.$lon,
        ]);
    }

    /**
     * Full-size map for this listing on openstreetmap.org, for the "view
     * larger map" link beside the embed. Null when there are no coordinates.
     */
    public function mapLinkUrl(): ?string
    {
        if (! $this->hasCoordinates()) {
            return null;
        }

        $lat = (float) $this->latitude;
        $lon = (float) $this->longitude;

        return 'https://www.openstreetmap.org/?mlat='.$lat.'&mlon='.$lon.'#map=16/'.$lat.'/'.$lon;
    }

    /**
     * Base query for anything a guest is allowed to see: approved by an
     * admin AND still flagged visible. Mirrors
     * PropertyController::visible() - kept here as well so the marketing
     * counters below apply exactly the same gate as the listing grid.
     */
    public static function publiclyVisible(): \Illuminate\Database\Eloquent\Builder
    {
        return static::query()
            ->where('listing_status', self::STATUS_APPROVED)
            ->where('is_visible', true);
    }

    /**
     * How many distinct Jaipur neighborhoods currently have at least one
     * live listing.
     *
     * The homepage ("N Neighborhoods Covered") and the browse header
     * ("Across N Jaipur neighborhoods") both read this. They used to carry
     * separate hardcoded numbers - 17 and 22 - which contradicted each
     * other and neither matched the data. Counting NEIGHBORHOODS is not
     * the same as counting the 22 entries in self::NEIGHBORHOODS: that
     * constant is the filter menu (everywhere a host MAY list), this is
     * coverage (everywhere a guest can actually book today).
     */
    public static function liveNeighborhoodCount(): int
    {
        return static::publiclyVisible()->distinct()->count('neighborhood');
    }

    /**
     * Admin-approved, and nothing else.
     *
     * This is the sole condition behind every "Verified" badge on the
     * site. The is_verified column is kept in sync by the approve/reject
     * actions, but it is a plain boolean that seeders, imports or a manual
     * DB edit can set independently - so reading it directly let listings
     * show as verified without an admin ever having looked at them, and
     * let genuinely approved listings show as unverified. Deriving the
     * badge from listing_status makes that drift impossible.
     */
    public function isVerified(): bool
    {
        return $this->listing_status === self::STATUS_APPROVED;
    }

    /**
     * Pre-filled wa.me link, or null if the host has no usable phone
     * number. Uses urlencode() (not rawurlencode()) deliberately: wa.me
     * expects the classic application/x-www-form-urlencoded style,
     * where a space becomes "+" rather than "%20".
     *
     * Access via $property->host->cleanWhatsappNumber() assumes 'host' is
     * loaded - every caller of this method already eager-loads it. That
     * accessor falls back to phone_number when the host has not set a
     * separate WhatsApp line, so this keeps working for every host who
     * registered before whatsapp_number existed.
     */
    public function whatsappUrl(): ?string
    {
        $phone = $this->host->cleanWhatsappNumber();

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

    /* ---------------------------------------------------------------- */
    /* Subscription state                                               */
    /*                                                                  */
    /* Three distinct cases the host dashboard has to tell apart:       */
    /*   never paid      - subscription_expiry is null                  */
    /*   paid, current   - expiry today or later                        */
    /*   paid, lapsed    - expiry in the past (the daily cron has       */
    /*                     already flipped is_visible off)              */
    /* ---------------------------------------------------------------- */

    public function hasActiveSubscription(): bool
    {
        return $this->subscription_expiry !== null
            && ! $this->subscription_expiry->isPast();
    }

    public function subscriptionHasExpired(): bool
    {
        return $this->subscription_expiry !== null
            && $this->subscription_expiry->isPast();
    }

    /**
     * Approved by an admin but not yet paid for, so the host can publish it
     * by subscribing. A pending or rejected listing must not be billable.
     */
    public function awaitingSubscription(): bool
    {
        return $this->listing_status === self::STATUS_APPROVED
            && ! $this->hasActiveSubscription();
    }

    /**
     * Whether this listing is currently covered by its host's Founding
     * Host promo (60 free days from registration), independent of any
     * paid subscription. See User::isFoundingHostActive().
     */
    public function isFoundingHostActive(): bool
    {
        return $this->relationLoaded('host')
            ? $this->host->isFoundingHostActive()
            : $this->host()->exists()
              && $this->host->isFoundingHostActive();
    }
}
