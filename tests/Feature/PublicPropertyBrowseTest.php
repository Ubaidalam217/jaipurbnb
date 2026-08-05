<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Covers the public browse grid (/browse) and single listing page
 * (/property/{id}).
 *
 * The rule every assertion here defends: a guest sees a listing only
 * when listing_status = 'approved' AND is_visible = true.
 */
class PublicPropertyBrowseTest extends TestCase
{
    use RefreshDatabase;

    /* ---------------- visibility gate ---------------- */

    public function test_browse_shows_only_approved_and_visible_listings(): void
    {
        $live = Property::factory()->live()->create(['title' => 'Live Haveli']);
        Property::factory()->create(['title' => 'Pending Haveli']);
        Property::factory()->create([
            'title'          => 'Rejected Haveli',
            'listing_status' => Property::STATUS_REJECTED,
            'is_visible'     => true,
        ]);
        // Approved but taken down by the expiry cron.
        Property::factory()->create([
            'title'          => 'Expired Haveli',
            'listing_status' => Property::STATUS_APPROVED,
            'is_visible'     => false,
        ]);

        $response = $this->get('/browse');

        $response->assertOk();
        $response->assertSee($live->title);
        $response->assertDontSee('Pending Haveli');
        $response->assertDontSee('Rejected Haveli');
        $response->assertDontSee('Expired Haveli');
    }

    public function test_the_filter_dropdowns_offer_every_neighborhood_and_stay_type(): void
    {
        // Guards against the constant drifting from CLAUDE.md's list again,
        // and against a listing existing in a neighborhood no guest can
        // filter by. 22 neighborhoods / 5 stay types are the agreed scope.
        $this->assertCount(22, Property::NEIGHBORHOODS);
        $this->assertCount(5, Property::STAY_TYPES);

        $response = $this->get('/browse')->assertOk();

        foreach (Property::NEIGHBORHOODS as $neighborhood) {
            $response->assertSee('<option value="'.$neighborhood.'"', false);
        }

        foreach (Property::STAY_TYPES as $stayType) {
            $response->assertSee('<option value="'.e($stayType).'"', false);
        }
    }

    public function test_the_newly_added_neighborhoods_are_filterable(): void
    {
        foreach (['Pratap Nagar', 'Chitrakoot', 'Jhotwara', 'Chomu', 'Bagru'] as $i => $neighborhood) {
            $property = Property::factory()->live()->create([
                'title'        => 'Stay Number '.$i,
                'neighborhood' => $neighborhood,
            ]);

            $this->get('/browse?'.http_build_query(['neighborhood' => $neighborhood]))
                ->assertOk()
                ->assertSee($property->title);
        }
    }

    public function test_browse_shows_the_empty_state_when_nothing_matches(): void
    {
        Property::factory()->live()->create(['neighborhood' => 'Amer']);

        $this->get('/browse?neighborhood=C-Scheme')
            ->assertOk()
            ->assertSee('No properties found matching your filters. Try adjusting your search.');
    }

    /* ---------------- filters ---------------- */

    public function test_it_filters_by_neighborhood(): void
    {
        Property::factory()->live()->create(['title' => 'Amer Stay', 'neighborhood' => 'Amer']);
        Property::factory()->live()->create(['title' => 'Scheme Stay', 'neighborhood' => 'C-Scheme']);

        $this->get('/browse?neighborhood=Amer')
            ->assertOk()
            ->assertSee('Amer Stay')
            ->assertDontSee('Scheme Stay');
    }

    public function test_it_filters_by_stay_type(): void
    {
        Property::factory()->live()->create(['title' => 'Hostel Bed', 'stay_type' => 'Backpacker Hostel']);
        Property::factory()->live()->create(['title' => 'Grand Villa', 'stay_type' => 'Luxury Villa / Farmhouse']);

        $this->get('/browse?'.http_build_query(['stay_type' => 'Backpacker Hostel']))
            ->assertOk()
            ->assertSee('Hostel Bed')
            ->assertDontSee('Grand Villa');
    }

    public function test_it_filters_by_price_range(): void
    {
        Property::factory()->live()->create(['title' => 'Budget Room', 'approx_price' => 900]);
        Property::factory()->live()->create(['title' => 'Midrange Room', 'approx_price' => 4000]);
        Property::factory()->live()->create(['title' => 'Premium Room', 'approx_price' => 20000]);

        $this->get('/browse?min_price=1000&max_price=10000')
            ->assertOk()
            ->assertSee('Midrange Room')
            ->assertDontSee('Budget Room')
            ->assertDontSee('Premium Room');
    }

    public function test_a_reversed_price_range_is_treated_as_the_range_meant(): void
    {
        Property::factory()->live()->create(['title' => 'Midrange Room', 'approx_price' => 4000]);

        $this->get('/browse?min_price=10000&max_price=1000')
            ->assertOk()
            ->assertSee('Midrange Room');
    }

    public function test_an_unknown_filter_value_is_ignored_rather_than_erroring(): void
    {
        Property::factory()->live()->create(['title' => 'Amer Stay', 'neighborhood' => 'Amer']);

        // Values a bookmark or crawler might send. None should 302 or 500.
        $this->get('/browse?neighborhood=Atlantis')->assertOk()->assertSee('Amer Stay');
        $this->get('/browse?stay_type=Spaceship')->assertOk()->assertSee('Amer Stay');
        $this->get('/browse?min_price=abc&max_price=-5')->assertOk()->assertSee('Amer Stay');
        $this->get('/browse?sort=whatever')->assertOk()->assertSee('Amer Stay');
        $this->get('/browse?neighborhood[]=Amer')->assertOk()->assertSee('Amer Stay');
    }

    /* ---------------- sorting ---------------- */

    public function test_it_sorts_by_price_low_to_high_and_high_to_low(): void
    {
        Property::factory()->live()->create(['title' => 'Cheapest', 'approx_price' => 1000]);
        Property::factory()->live()->create(['title' => 'Priciest', 'approx_price' => 9000]);

        $this->get('/browse?sort=price_low')->assertSeeInOrder(['Cheapest', 'Priciest']);
        $this->get('/browse?sort=price_high')->assertSeeInOrder(['Priciest', 'Cheapest']);
    }

    public function test_it_sorts_newest_first_by_default(): void
    {
        Property::factory()->live()->create(['title' => 'Older Stay', 'created_at' => now()->subWeek()]);
        Property::factory()->live()->create(['title' => 'Newer Stay', 'created_at' => now()]);

        $this->get('/browse')->assertSeeInOrder(['Newer Stay', 'Older Stay']);
    }

    /* ---------------- pagination ---------------- */

    public function test_it_paginates_nine_per_page_and_keeps_filters_on_the_links(): void
    {
        Property::factory()->live()->count(12)->create(['neighborhood' => 'Amer']);

        $page1 = $this->get('/browse?neighborhood=Amer');
        $page1->assertOk();
        $this->assertCount(9, $page1->viewData('properties')->items());
        // The "next" link must carry the filter, or page 2 silently widens.
        $page1->assertSee('neighborhood=Amer', false);

        $page2 = $this->get('/browse?neighborhood=Amer&page=2');
        $this->assertCount(3, $page2->viewData('properties')->items());
    }

    /* ---------------- single listing page ---------------- */

    public function test_it_shows_an_approved_visible_listing(): void
    {
        $property = Property::factory()->live()->create([
            'title'        => 'The Royal Walled City Haveli',
            'description'  => 'A restored heritage haveli with a rooftop terrace.',
            'neighborhood' => 'Walled City',
            'approx_price' => 2500,
        ]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertSee('The Royal Walled City Haveli')
            ->assertSee('A restored heritage haveli with a rooftop terrace.')
            ->assertSee('Walled City')
            ->assertSee('Approx Rs 2,500 / night');
    }

    public function test_it_renders_the_listings_own_photos(): void
    {
        $property = Property::factory()->live()->create();
        PropertyImage::create([
            'property_id' => $property->id,
            'image_url'   => 'properties/'.$property->id.'/cover.jpg',
            'is_cover'    => true,
        ]);

        $this->get('/property/'.$property->id)
            ->assertOk()
            ->assertSee('/storage/properties/'.$property->id.'/cover.jpg', false);
    }

    public function test_it_404s_for_a_listing_a_guest_may_not_see(): void
    {
        $pending  = Property::factory()->create();
        $rejected = Property::factory()->create(['listing_status' => Property::STATUS_REJECTED, 'is_visible' => true]);
        $expired  = Property::factory()->create(['listing_status' => Property::STATUS_APPROVED, 'is_visible' => false]);

        $this->get('/property/'.$pending->id)->assertNotFound();
        $this->get('/property/'.$rejected->id)->assertNotFound();
        $this->get('/property/'.$expired->id)->assertNotFound();
        $this->get('/property/999999')->assertNotFound();
    }

    public function test_a_deleted_listing_disappears_from_browse_and_404s(): void
    {
        $property = Property::factory()->live()->create(['title' => 'Soon Gone']);

        $this->get('/browse')->assertSee('Soon Gone');

        $property->delete();

        $this->get('/browse')->assertDontSee('Soon Gone');
        $this->get('/property/'.$property->id)->assertNotFound();
    }

    /* ---------------- routing ---------------- */

    public function test_the_legacy_template_urls_redirect_to_browse(): void
    {
        $this->get('/apartment/v4')->assertRedirect(route('properties.browse'));
        $this->get('/single/index5')->assertRedirect(route('properties.browse'));
    }

    public function test_browse_is_reachable_without_signing_in(): void
    {
        $this->assertGuest();
        $this->get('/browse')->assertOk();
    }
}
