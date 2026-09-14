<?php

namespace Tests\Feature;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\PropertyAvailability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The three new /browse filters: check-in/check-out date availability,
 * amenity checkboxes, and pet-friendly. Plus the guests dropdown's new
 * ceiling of 16 (was 8).
 */
class BrowseNewFiltersTest extends TestCase
{
    use RefreshDatabase;

    /* ---------------- date availability ---------------- */

    public function test_a_listing_blocked_inside_the_requested_range_is_excluded(): void
    {
        $open = Property::factory()->live()->create(['title' => 'Wide Open Haveli']);
        $blocked = Property::factory()->live()->create(['title' => 'Booked Out Villa']);

        PropertyAvailability::create([
            'property_id'   => $blocked->id,
            'calendar_date' => '2026-10-05',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
        ]);

        $this->get('/browse?check_in=2026-10-01&check_out=2026-10-10')
            ->assertOk()
            ->assertSee('Wide Open Haveli')
            ->assertDontSee('Booked Out Villa');
    }

    public function test_a_listing_with_no_availability_rows_is_available_by_default(): void
    {
        Property::factory()->live()->create(['title' => 'Never Blocked']);

        $this->get('/browse?check_in=2026-10-01&check_out=2026-10-10')
            ->assertOk()
            ->assertSee('Never Blocked');
    }

    public function test_a_block_outside_the_requested_range_does_not_exclude_the_listing(): void
    {
        $property = Property::factory()->live()->create(['title' => 'Blocked Later']);

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => '2026-12-25',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
        ]);

        $this->get('/browse?check_in=2026-10-01&check_out=2026-10-10')
            ->assertOk()
            ->assertSee('Blocked Later');
    }

    public function test_a_booked_date_also_excludes_the_listing(): void
    {
        $property = Property::factory()->live()->create(['title' => 'Already Booked']);

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => '2026-10-03',
            'status'        => PropertyAvailability::STATUS_BOOKED,
        ]);

        $this->get('/browse?check_in=2026-10-01&check_out=2026-10-10')
            ->assertOk()
            ->assertDontSee('Already Booked');
    }

    public function test_the_checkout_night_itself_is_not_checked(): void
    {
        // A guest leaving on the 10th does not occupy the night of the
        // 10th, so a block that day must not exclude the listing.
        $property = Property::factory()->live()->create(['title' => 'Checkout Day Block']);

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => '2026-10-10',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
        ]);

        $this->get('/browse?check_in=2026-10-01&check_out=2026-10-10')
            ->assertOk()
            ->assertSee('Checkout Day Block');
    }

    public function test_a_lone_check_in_without_check_out_is_ignored(): void
    {
        $property = Property::factory()->live()->create(['title' => 'Lone Date']);

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => '2026-10-05',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
        ]);

        // Only check_in given - the filter must not silently apply.
        $this->get('/browse?check_in=2026-10-01')
            ->assertOk()
            ->assertSee('Lone Date');
    }

    public function test_a_reversed_date_range_is_ignored_rather_than_erroring(): void
    {
        Property::factory()->live()->create(['title' => 'Any Stay']);

        $this->get('/browse?check_in=2026-10-10&check_out=2026-10-01')
            ->assertOk()
            ->assertSee('Any Stay');
    }

    public function test_a_malformed_date_is_ignored_rather_than_erroring(): void
    {
        Property::factory()->live()->create(['title' => 'Any Stay']);

        $this->get('/browse?check_in=not-a-date&check_out=also-not-a-date')
            ->assertOk()
            ->assertSee('Any Stay');
    }

    /* ---------------- amenities ---------------- */

    public function test_the_amenity_filter_requires_every_ticked_amenity(): void
    {
        $wifi = Amenity::create(['name' => 'Wifi', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wifi']);
        $pool = Amenity::create(['name' => 'Pool', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-person-swimming']);

        $both = Property::factory()->live()->create(['title' => 'Wifi And Pool']);
        $both->amenities()->sync([$wifi->id, $pool->id]);

        $wifiOnly = Property::factory()->live()->create(['title' => 'Wifi Only']);
        $wifiOnly->amenities()->sync([$wifi->id]);

        $this->get('/browse?'.http_build_query(['amenities' => [$wifi->id, $pool->id]]))
            ->assertOk()
            ->assertSee('Wifi And Pool')
            ->assertDontSee('Wifi Only');
    }

    public function test_a_single_amenity_filter_matches_any_listing_with_it(): void
    {
        $wifi = Amenity::create(['name' => 'Wifi', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wifi']);

        $withWifi = Property::factory()->live()->create(['title' => 'Has Wifi']);
        $withWifi->amenities()->sync([$wifi->id]);
        Property::factory()->live()->create(['title' => 'No Wifi']);

        $this->get('/browse?'.http_build_query(['amenities' => [$wifi->id]]))
            ->assertOk()
            ->assertSee('Has Wifi')
            ->assertDontSee('No Wifi');
    }

    /* ---------------- pet-friendly ---------------- */

    public function test_the_pet_friendly_filter_excludes_non_pet_friendly_listings(): void
    {
        Property::factory()->live()->create(['title' => 'Pets Welcome', 'is_pet_friendly' => true]);
        Property::factory()->live()->create(['title' => 'No Pets', 'is_pet_friendly' => false]);

        $this->get('/browse?pet_friendly=1')
            ->assertOk()
            ->assertSee('Pets Welcome')
            ->assertDontSee('No Pets');
    }

    public function test_pet_friendly_listings_show_a_badge_on_the_card(): void
    {
        Property::factory()->live()->create(['title' => 'Pets Welcome', 'is_pet_friendly' => true]);

        $this->get('/browse')
            ->assertOk()
            ->assertSee('Pet-friendly');
    }

    /* ---------------- guests up to 16 ---------------- */

    public function test_the_guests_dropdown_offers_up_to_sixteen(): void
    {
        $this->get('/browse')->assertOk()->assertSee('16+ guests');
    }

    public function test_a_sixteen_guest_listing_is_findable(): void
    {
        Property::factory()->live()->create(['title' => 'Huge Villa', 'max_guests' => 16]);

        $this->get('/browse?guests=16')
            ->assertOk()
            ->assertSee('Huge Villa');
    }
}
