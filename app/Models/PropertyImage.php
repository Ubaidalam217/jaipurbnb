<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A single photo attached to a property listing (max 15 per listing -
 * that cap is enforced in the FormRequest, not in the schema).
 *
 * image_url stores a path relative to the public disk, e.g.
 * "properties/17/abc123.jpg", served via /storage/properties/...
 */
class PropertyImage extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'property_id',
        'image_url',
        'is_cover',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'is_cover' => 'boolean',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
