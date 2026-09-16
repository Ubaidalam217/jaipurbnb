<?php

namespace Tests\Feature;

use App\Models\PropertyImage;
use Tests\TestCase;

/**
 * PropertyImage::$display_url has to cope with three shapes of stored path,
 * and getting it wrong fails silently - the page still renders, the <img>
 * just 404s, which is easy to miss in a code review and easy to miss on a
 * staging pass if the browser has the old image cached.
 *
 * The root-relative case is the one that regressed: seeded demo photos stored
 * as "/img/all-images/..." were run through Storage::url() and came back as
 * "/storage/img/all-images/...", so every demo listing on production showed a
 * broken image. It was worked around at the time by rewriting the rows to
 * fully qualified https://jaipurbnb.com/... URLs, which hardcodes the domain
 * and breaks on local and staging.
 */
class PropertyImageUrlTest extends TestCase
{
    /**
     * @dataProvider paths
     */
    public function test_display_url_resolves_each_stored_path_shape(string $stored, string $expected): void
    {
        // Not persisted: display_url is a pure accessor over image_url, so a
        // DB round trip would only slow the test down.
        $image = new PropertyImage(['image_url' => $stored]);

        $this->assertSame($expected, $image->display_url);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function paths(): array
    {
        return [
            'absolute https passes through' => [
                'https://example.com/a.jpg', 'https://example.com/a.jpg',
            ],
            'absolute http passes through' => [
                'http://example.com/a.jpg', 'http://example.com/a.jpg',
            ],
            'protocol-relative passes through' => [
                '//example.com/a.jpg', '//example.com/a.jpg',
            ],
            // Must be checked before the single-slash rule, or this is
            // mistaken for a local path.
            'protocol-relative is not treated as a local path' => [
                '//cdn.example.com/x/y.png', '//cdn.example.com/x/y.png',
            ],
            'root-relative public asset passes through' => [
                '/img/all-images/hero/hero-img6.webp', '/img/all-images/hero/hero-img6.webp',
            ],
            'disk-relative upload goes through Storage::url' => [
                'properties/ab12.jpg', '/storage/properties/ab12.jpg',
            ],
        ];
    }
}
