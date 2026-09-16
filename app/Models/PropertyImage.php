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
     * Three shapes reach this accessor:
     *
     *   "properties/ab12.jpg"      real host upload, disk-relative -> Storage::url()
     *   "/img/all-images/..."      file shipped in public/, already a valid src
     *   "https://host/img.jpg"     absolute; protocol-relative "//host/" counts too
     *
     * The middle case is the one that used to be wrong: a leading slash is not
     * matched by the absolute check, so seeded demo photos fell through to
     * Storage::url() and came back as "/storage/img/all-images/..." - a 404.
     * That is why production's demo images were once repointed to fully
     * qualified https://jaipurbnb.com/img/... URLs; handling the root-relative
     * form here is the real fix and keeps the paths portable across local,
     * staging and production.
     *
     * Order matters: check "//" (protocol-relative) BEFORE the single-slash
     * case, or "//host/img.jpg" would be misread as a local path.
     */
    protected function displayUrl(): Attribute
    {
        return Attribute::get(function (): string {
            $path = (string) $this->image_url;

            if (Str::startsWith($path, ['http://', 'https://', '//'])) {
                return $path;
            }

            if (Str::startsWith($path, '/')) {
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
