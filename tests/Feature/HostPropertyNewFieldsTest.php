<?php

namespace Tests\Feature;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * The five client-requested additions to the host create/edit form:
 * adults/children/infants -> derived max_guests, pet-friendly, lat/lng,
 * address fields, and the amenities multi-select.
 */
class HostPropertyNewFieldsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'title'         => 'Test Haveli',
            'description'   => 'A lovely place to stay for twenty characters.',
            'neighborhood'  => 'Amer',
            'stay_type'     => 'Homestay / Guest House',
            'approx_price'  => 2000,
            'max_adults'    => 4,
            'max_children'  => 2,
            'max_infants'   => 1,
            'bedrooms'      => 2,
            'bathrooms'     => 1,
            'is_pet_friendly' => '1',
            'latitude'      => '26.9124',
            'longitude'     => '75.7873',
            'full_address'  => '123 Test Street, near the fort',
            'city'          => 'Jaipur',
            'state'         => 'Rajasthan',
            'pincode'       => '302001',
            'photos'        => [UploadedFile::fake()->image('cover.jpg')],
            'cover_index'   => 0,
        ], $overrides);
    }

    /* ---------------- max_guests derivation ---------------- */

    public function test_storing_a_listing_derives_max_guests_from_adults_plus_children(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $this->actingAs($host)
            ->post(route('host.properties.store'), $this->payload(['max_adults' => 5, 'max_children' => 3, 'max_infants' => 2]))
            ->assertRedirect(route('host.properties.index'));

        $property = Property::first();

        $this->assertSame(5, $property->max_adults);
        $this->assertSame(3, $property->max_children);
        $this->assertSame(2, $property->max_infants);
        // Infants never count toward the derived total.
        $this->assertSame(8, $property->max_guests);
    }

    public function test_a_posted_max_guests_value_is_ignored_in_favour_of_the_derived_one(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $this->actingAs($host)->post(route('host.properties.store'), $this->payload([
            'max_adults'   => 2,
            'max_children' => 0,
            // A crafted request trying to set a max_guests the client
            // cannot otherwise reach.
            'max_guests'   => 999,
        ]))->assertRedirect(route('host.properties.index'));

        $this->assertSame(2, Property::first()->max_guests);
    }

    public function test_updating_a_listing_re_derives_max_guests(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $property = Property::factory()->create(['host_id' => $host->id]);

        $this->actingAs($host)->put(route('host.properties.update', $property), $this->payload([
            'max_adults'   => 6,
            'max_children' => 4,
        ]))->assertRedirect(route('host.properties.index'));

        $property->refresh();
        $this->assertSame(10, $property->max_guests);
    }

    /* ---------------- pet-friendly ---------------- */

    public function test_storing_a_listing_saves_the_pet_friendly_flag(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $this->actingAs($host)->post(route('host.properties.store'), $this->payload(['is_pet_friendly' => '1']));
        $this->assertTrue(Property::first()->is_pet_friendly);
    }

    public function test_an_unticked_pet_friendly_checkbox_saves_as_false(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $payload = $this->payload();
        unset($payload['is_pet_friendly']);

        $this->actingAs($host)->post(route('host.properties.store'), $payload);
        $this->assertFalse(Property::first()->is_pet_friendly);
    }

    /* ---------------- location + address ---------------- */

    public function test_storing_a_listing_saves_coordinates_and_address(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $this->actingAs($host)->post(route('host.properties.store'), $this->payload());

        $property = Property::first();
        $this->assertSame('26.91240000', $property->latitude);
        $this->assertSame('75.78730000', $property->longitude);
        $this->assertSame('123 Test Street, near the fort', $property->full_address);
        $this->assertSame('Jaipur', $property->city);
        $this->assertSame('Rajasthan', $property->state);
        $this->assertSame('302001', $property->pincode);
        $this->assertTrue($property->hasCoordinates());
    }

    public function test_coordinates_are_optional(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $payload = $this->payload();
        unset($payload['latitude'], $payload['longitude']);

        $this->actingAs($host)->post(route('host.properties.store'), $payload)
            ->assertSessionDoesntHaveErrors();

        $this->assertFalse(Property::first()->hasCoordinates());
    }

    /* ---------------- amenities ---------------- */

    public function test_storing_a_listing_syncs_the_ticked_amenities(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $wifi = Amenity::create(['name' => 'Wifi', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wifi']);
        $pool = Amenity::create(['name' => 'Pool', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-person-swimming']);

        $this->actingAs($host)->post(route('host.properties.store'), $this->payload([
            'amenities' => [$wifi->id, $pool->id],
        ]));

        $property = Property::first();
        $this->assertSame([$wifi->id, $pool->id], $property->amenities->pluck('id')->sort()->values()->all());
    }

    public function test_updating_a_listing_replaces_its_amenities(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $property = Property::factory()->create(['host_id' => $host->id]);
        $wifi = Amenity::create(['name' => 'Wifi', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wifi']);
        $pool = Amenity::create(['name' => 'Pool', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-person-swimming']);
        $property->amenities()->sync([$wifi->id]);

        $this->actingAs($host)->put(route('host.properties.update', $property), $this->payload([
            'amenities' => [$pool->id],
        ]));

        $this->assertSame([$pool->id], $property->fresh()->amenities->pluck('id')->all());
    }

    public function test_amenities_can_be_cleared_entirely(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $property = Property::factory()->create(['host_id' => $host->id]);
        $wifi = Amenity::create(['name' => 'Wifi', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wifi']);
        $property->amenities()->sync([$wifi->id]);

        $payload = $this->payload();
        unset($payload['amenities']);

        $this->actingAs($host)->put(route('host.properties.update', $property), $payload);

        $this->assertTrue($property->fresh()->amenities->isEmpty());
    }
}
