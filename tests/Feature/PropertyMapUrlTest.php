<?php

namespace Tests\Feature;

use App\Models\Property;
use Tests\TestCase;

/**
 * The map embed silently rendered nothing for a long time: Google's keyless
 * `maps.google.com/maps?...&output=embed` endpoint answers 301 with
 * X-Frame-Options: SAMEORIGIN, and a browser enforces that on the redirect,
 * so the iframe was blocked. Nothing in the HTML looked wrong, which is
 * exactly why this needs a test.
 *
 * The bbox is also easy to get subtly wrong: its order is longitude-first
 * while the marker beside it is latitude-first, and swapping them moves the
 * map to the wrong place rather than erroring.
 */
class PropertyMapUrlTest extends TestCase
{
    private function at(float $lat, float $lon): Property
    {
        // Not persisted - these are pure accessors over two columns.
        return new Property(['latitude' => $lat, 'longitude' => $lon]);
    }

    public function test_it_returns_null_without_coordinates(): void
    {
        $this->assertNull((new Property)->mapEmbedUrl());
        $this->assertNull((new Property)->mapLinkUrl());

        // Half-filled rows must not produce a broken embed either.
        $this->assertNull((new Property(['latitude' => 26.9239]))->mapEmbedUrl());
        $this->assertNull((new Property(['longitude' => 75.8267]))->mapEmbedUrl());
    }

    public function test_it_builds_an_openstreetmap_embed_not_google(): void
    {
        $url = $this->at(26.9239, 75.8267)->mapEmbedUrl();

        $this->assertStringStartsWith('https://www.openstreetmap.org/export/embed.html?', $url);
        $this->assertStringNotContainsString('google', $url);
    }

    public function test_the_bbox_is_longitude_first_and_brackets_the_marker(): void
    {
        $lat = 26.9239;
        $lon = 75.8267;

        parse_str(parse_url($this->at($lat, $lon)->mapEmbedUrl(), PHP_URL_QUERY), $q);

        [$minLon, $minLat, $maxLon, $maxLat] = array_map('floatval', explode(',', $q['bbox']));

        // Longitude first. If these were swapped the values would be ~26 and
        // ~75 the other way round, which is what this pins down.
        $this->assertEqualsWithDelta($lon, ($minLon + $maxLon) / 2, 0.0001);
        $this->assertEqualsWithDelta($lat, ($minLat + $maxLat) / 2, 0.0001);

        // The pin sits strictly inside the frame.
        $this->assertGreaterThan($minLon, $lon);
        $this->assertLessThan($maxLon, $lon);
        $this->assertGreaterThan($minLat, $lat);
        $this->assertLessThan($maxLat, $lat);

        // Marker is latitude-first - the opposite order from bbox.
        $this->assertSame($lat.','.$lon, $q['marker']);
    }

    public function test_the_span_is_a_neighbourhood_not_a_continent(): void
    {
        parse_str(parse_url($this->at(26.9239, 75.8267)->mapEmbedUrl(), PHP_URL_QUERY), $q);
        [$minLon, $minLat, $maxLon, $maxLat] = array_map('floatval', explode(',', $q['bbox']));

        // ~0.016 deg across: roughly 1.6km. Wide enough to orient, tight
        // enough to be useful.
        $this->assertEqualsWithDelta(0.016, $maxLon - $minLon, 0.0005);
        $this->assertEqualsWithDelta(0.016, $maxLat - $minLat, 0.0005);
    }

    public function test_the_larger_map_link_points_at_the_same_pin(): void
    {
        $url = $this->at(26.9239, 75.8267)->mapLinkUrl();

        $this->assertStringContainsString('mlat=26.9239', $url);
        $this->assertStringContainsString('mlon=75.8267', $url);
    }

    /**
     * latitude/longitude are cast decimal:8, so they arrive as strings like
     * "26.92390000". Arithmetic on those must still yield a numeric bbox
     * rather than something like "26.92390000-0.008".
     */
    public function test_it_handles_the_decimal_cast_string_form(): void
    {
        $property = new Property;
        $property->latitude = '26.92390000';
        $property->longitude = '75.82670000';

        parse_str(parse_url($property->mapEmbedUrl(), PHP_URL_QUERY), $q);

        foreach (explode(',', $q['bbox']) as $part) {
            $this->assertIsNumeric($part);
        }
    }
}
