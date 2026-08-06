<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A single photo attached to a property listing (max 15 per listing -
 * that cap is enforced in the FormRequest, not in the schema).
 *
 * image_url stores a path relative to the public disk, e.g.
 * "properties/17/abc123.jpg", served via /storage/properties/...
 *
 * ...EXCEPT for demo/seeded rows, which store a fully qualified remote
 * URL instead. Storage::url() would happily mangle those into
 * "/storage/https://..." so always render through $image->display_url,
 * never Storage::url($image->image_url) directly.
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

    /**
     * Browser-ready src for this photo.
     *
     * Real host uploads are disk-relative and need Storage::url(). Seeded
     * demo photos are already absolute remote URLs and must pass through
     * untouched. Protocol-relative ("//host/img.jpg") counts as absolute.
     */
    protected function displayUrl(): Attribute
    {
        return Attribute::get(function (): string {
            $path = (string) $this->image_url;

            if (Str::startsWith($path, ['http://', 'https://', '//'])) {
                return $path;
            }

            return Storage::url($path);
        });
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
