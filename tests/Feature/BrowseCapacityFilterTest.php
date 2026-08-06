<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The guests / bedrooms filters on /browse.
 *
 * Both read as "n or more". Offered values come from
 * PropertyController::GUEST_OPTIONS / BEDROOM_OPTIONS; anything else is
 * treated as "no filter" rather than returning an empty page, matching how
 * the existing neighborhood and price params already behave.
 */
class BrowseCapacityFilterTest extends TestCase
{
    use RefreshDatabase;

    private function live(int $guests, int $bedrooms, string $title): Property
    {
        return Property::factory()->live()->create([
            'title'      => $title,
            'max_guests' => $guests,
            'bedrooms'   => $bedrooms,
            'bathrooms'  => 1,
        ]);
    }

    public function test_the_guests_filter_excludes_smaller_listings(): void
    {
        $this->live(2, 1, 'Tiny Studio');
        $this->live(8, 4, 'Big Villa');

        $this->get('/browse?guests=6')
            ->assertStatus(200)
            ->assertSee('Big Villa')
            ->assertDontSee('Tiny Studio');
    }

    public function test_the_bedrooms_filter_excludes_smaller_listings(): void
    {
        $this->live(4, 1, 'One Bed Flat');
        $this->live(4, 3, 'Three Bed House');

        $this->get('/browse?bedrooms=3')
            ->assertStatus(200)
            ->assertSee('Three Bed House')
            ->assertDontSee('One Bed Flat');
    }

    public function test_a_listing_exactly_on_the_boundary_is_included(): void
    {
        $this->live(4, 2, 'Exactly Four');

        $this->get('/browse?guests=4')
            ->assertStatus(200)
            ->assertSee('Exactly Four');
    }

    public function test_the_two_capacity_filters_combine(): void
    {
        $this->live(8, 1, 'Many Guests One Bed');
        $this->live(8, 4, 'Many Guests Many Beds');

        $this->get('/browse?guests=6&bedrooms=3')
            ->assertStatus(200)
            ->assertSee('Many Guests Many Beds')
            ->assertDontSee('Many Guests One Bed');
    }

    public function test_capacity_combines_with_the_existing_neighborhood_filter(): void
    {
        $this->live(8, 4, 'Amer Big Place')->update(['neighborhood' => 'Amer']);
        $this->live(8, 4, 'Nahargarh Big Place')->update(['neighborhood' => 'Nahargarh']);

        $this->get('/browse?guests=6&neighborhood=Amer')
            ->assertStatus(200)
            ->assertSee('Amer Big Place')
            ->assertDontSee('Nahargarh Big Place');
    }

    public function test_an_unoffered_value_is_ignored_rather_than_returning_nothing(): void
    {
        $this->live(2, 1, 'Small Place');

        // ?guests=999 is not on the dropdown. Returning zero results would
        // read as "we have nothing", so it must fall back to no filter.
        $this->get('/browse?guests=999')
            ->assertStatus(200)
            ->assertSee('Small Place');
    }

    public function test_a_non_numeric_value_is_ignored(): void
    {
        $this->live(2, 1, 'Small Place');

        $this->get('/browse?guests=abc&bedrooms=-3')
            ->assertStatus(200)
            ->assertSee('Small Place');
    }

    public function test_cards_show_the_real_capacity(): void
    {
        $this->live(6, 3, 'Capacity Card Test');

        $this->get('/browse')
            ->assertStatus(200)
            ->assertSee('6 guests')
            ->assertSee('3 bedrooms');
    }

    public function test_singular_wording_for_a_one_bedroom_listing(): void
    {
        $this->live(1, 1, 'Single Everything');

        $this->get('/browse')
            ->assertStatus(200)
            ->assertSee('1 guest')
            ->assertSee('1 bedroom');
    }
}
