<?php

namespace Tests\Feature;

use App\Models\Amenity;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * What the property detail page (/property/{id}) renders for the new
 * columns: amenities list, pet-friendly badge, address panel and the
 * Google Maps embed.
 */
class PropertyDetailNewFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_the_propertys_amenities(): void
    {
        $wifi = Amenity::create(['name' => 'Wifi', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wifi']);
        $pool = Amenity::create(['name' => 'Pool', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-person-swimming']);
        $property = Property::factory()->live()->create();
        $property->amenities()->sync([$wifi->id, $pool->id]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertSee('Wifi')
            ->assertSee('Pool');
    }

    public function test_it_shows_nothing_extra_when_the_listing_has_no_amenities(): void
    {
        $property = Property::factory()->live()->create();

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertDontSee('What this place offers');
    }

    public function test_a_pet_friendly_listing_shows_the_badge(): void
    {
        $property = Property::factory()->live()->create(['is_pet_friendly' => true]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertSee('Pet-friendly');
    }

    public function test_a_non_pet_friendly_listing_does_not_show_the_badge(): void
    {
        $property = Property::factory()->live()->create(['is_pet_friendly' => false]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertDontSee('Pet-friendly');
    }

    public function test_it_shows_the_full_address_and_city_state(): void
    {
        $property = Property::factory()->live()->create([
            'full_address' => '42 Heritage Lane',
            'city'         => 'Jaipur',
            'state'        => 'Rajasthan',
            'pincode'      => '302002',
        ]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertSee('42 Heritage Lane')
            ->assertSee('302002');
    }

    public function test_it_embeds_a_map_when_coordinates_are_set(): void
    {
        $property = Property::factory()->live()->create([
            'latitude'  => 26.9124,
            'longitude' => 75.7873,
        ]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertSee('26.9124', false)
            ->assertSee('maps.google.com', false);
    }

    public function test_no_map_is_rendered_without_coordinates(): void
    {
        $property = Property::factory()->live()->create([
            'latitude'  => null,
            'longitude' => null,
        ]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertDontSee('maps.google.com', false);
    }
}
