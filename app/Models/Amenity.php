<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A single amenity a host can tick on their listing (Wifi, Pool, ...).
 *
 * category is a plain string column (no DB-level ENUM, for
 * SQLite+MySQL portability) - validate against self::CATEGORIES
 * wherever this is written. AmenitySeeder is the only writer today.
 *
 * No updated_at column exists on this table (see the migration), so
 * UPDATED_AT is nulled out - Eloquent would otherwise try to write a
 * column that is not there on every save().
 */
class Amenity extends Model
{
    public const CATEGORY_BASICS   = 'basics';
    public const CATEGORY_POPULAR  = 'popular';
    public const CATEGORY_FEATURES = 'features';
    public const CATEGORY_LOCATION = 'location';

    public const CATEGORIES = [
        self::CATEGORY_BASICS,
        self::CATEGORY_POPULAR,
        self::CATEGORY_FEATURES,
        self::CATEGORY_LOCATION,
    ];

    public const UPDATED_AT = null;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'category',
        'icon',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_amenities');
    }
}
