<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Env;
use Tests\TestCase;

/**
 * Regressions for the client content pass: no invented guest reviews, no
 * hardcoded support number, no subscription wording inside a listing
 * title, one shared neighborhood count, source-neutral calendar labels,
 * and a Verified badge that means admin approval and nothing else.
 */
class ContentCleanupTest extends TestCase
{
    use RefreshDatabase;

    /* ---------------- demo reviews / testimonials ---------------- */

    public function test_the_homepage_carries_no_demo_reviews_or_testimonials(): void
    {
        Property::factory()->live()->create();

        $response = $this->get('/')->assertOk();

        // Markup hooks, invented reviewer names and the "these are fake"
        // disclaimer that used to sit above them.
        $response->assertDontSee('testimonial', false);
        $response->assertDontSee('Priya Sharma');
        $response->assertDontSee('Happy Guest');
        $response->assertDontSee('sample reviews');
        $response->assertDontSee('Hear What Our Guests Say');
    }

    /* ---------------- platform contact number ---------------- */

    public function test_the_support_number_comes_from_config_not_the_markup(): void
    {
        config([
            'contact.phone'     => '+91 12345 67890',
            'contact.phone_tel' => '+911234567890',
        ]);

        foreach (['/', '/contact'] as $url) {
            $response = $this->get($url)->assertOk();

            $response->assertSee('+91 12345 67890');
            $response->assertSee('tel:+911234567890', false);
            // The number the template used to ship with.
            $response->assertDontSee('98765 43210');
        }
    }

    /**
     * The guard here is that config/contact.php never ships a REAL number as
     * its fallback, so an unconfigured deployment reads as obviously unset
     * rather than dialling a stranger.
     *
     * It re-evaluates the config file with CONTACT_PHONE cleared from the env
     * repository, because that is the situation being asserted about. Reading
     * config('contact.phone') directly - as this did originally - only passes
     * on a machine whose .env happens not to set CONTACT_PHONE, so it failed
     * on every developer machine and on production, where it is set to the
     * client's real support line.
     */
    public function test_the_shipped_default_is_an_obvious_placeholder(): void
    {
        $repository = Env::getRepository();
        $original = $repository->get('CONTACT_PHONE');
        $repository->clear('CONTACT_PHONE');

        try {
            $config = require config_path('contact.php');

            $this->assertSame('+91 00000 00000', $config['phone']);
            $this->assertSame('+910000000000', $config['phone_tel']);
        } finally {
            // Restore, or every later test in this process sees the default.
            if ($original !== null) {
                $repository->set('CONTACT_PHONE', $original);
            }
        }
    }

    /* ---------------- subscription state vs listing title ---------------- */

    public function test_the_listing_grid_carries_no_subscription_call_to_action(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        // A lapsed listing and a never-paid one - the two states that used
        // to render "Renew Subscription" and "Subscribe to Publish".
        Property::factory()->expired()->create([
            'host_id' => $host->id,
            'title'   => 'Nahargarh Heritage Retreat',
        ]);
        Property::factory()->live()->create([
            'host_id'             => $host->id,
            'title'               => 'Bani Park Boutique Getaway',
            'subscription_expiry' => null,
        ]);

        $response = $this->actingAs($host)->get('/host/properties')->assertOk();

        $response->assertDontSee('Renew Subscription');
        $response->assertDontSee('Subscribe to Publish');
        $response->assertDontSee('jb-row__sub', false);
        $response->assertDontSee('jb-sub-cta', false);

        // ...and the titles are still just titles.
        preg_match_all('/<h2 class="jb-row__title">(.*?)<\/h2>/s', $response->getContent(), $titles);

        $this->assertCount(2, $titles[1], 'Expected both listing titles to render.');

        foreach ($titles[1] as $title) {
            $this->assertContains(trim($title), [
                'Nahargarh Heritage Retreat',
                'Bani Park Boutique Getaway',
            ]);
        }
    }

    public function test_the_plans_page_is_still_reachable_from_the_listing_detail_page(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $lapsed = Property::factory()->expired()->create(['host_id' => $host->id]);
        $pending = Property::factory()->create(['host_id' => $host->id]);

        // Removing the grid CTAs must not orphan the payment flow.
        $this->actingAs($host)->get('/host/properties/'.$lapsed->id)
            ->assertOk()
            ->assertSee('Manage Subscription')
            ->assertSee(route('host.properties.plans', $lapsed), false);

        // Nothing to bill for on a listing no admin has approved.
        $this->actingAs($host)->get('/host/properties/'.$pending->id)
            ->assertOk()
            ->assertDontSee('Manage Subscription');
    }

    /* ---------------- neighborhood count ---------------- */

    public function test_both_pages_show_the_same_db_derived_neighborhood_count(): void
    {
        // Three distinct neighborhoods across four live listings, plus a
        // pending one in a fourth neighborhood that must not count.
        Property::factory()->live()->create(['neighborhood' => 'Amer']);
        Property::factory()->live()->create(['neighborhood' => 'Amer']);
        Property::factory()->live()->create(['neighborhood' => 'C-Scheme']);
        Property::factory()->live()->create(['neighborhood' => 'Bani Park']);
        Property::factory()->create(['neighborhood' => 'Chomu']);

        $this->assertSame(3, Property::liveNeighborhoodCount());

        $this->get('/')->assertOk()
            ->assertSee('3 Neighborhoods Covered')
            ->assertDontSee('17 Neighborhoods');

        $this->get('/browse')->assertOk()
            ->assertSee('Across 3 Jaipur neighborhoods')
            ->assertDontSee('Across 22 Jaipur');
    }

    public function test_the_browse_count_survives_a_filter_that_matches_nothing(): void
    {
        Property::factory()->live()->create(['neighborhood' => 'Amer']);
        Property::factory()->live()->create(['neighborhood' => 'C-Scheme']);

        // No listing in Chomu - the grid is empty, but site-wide coverage
        // is still 2 and is exactly what this guest needs to be told.
        $this->get('/browse?neighborhood=Chomu')->assertOk()
            ->assertSee('No properties found matching your filters. Try adjusting your search.')
            ->assertSee('Across 2 Jaipur neighborhoods')
            ->assertSee('0 stays available');
    }

    public function test_the_browse_count_is_hidden_when_nothing_is_live(): void
    {
        Property::factory()->create(['neighborhood' => 'Amer']); // pending

        $this->get('/browse')->assertOk()->assertDontSee('Jaipur neighborhood');
    }

    public function test_the_homepage_makes_no_coverage_claim_with_nothing_live(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('Neighborhoods Across Jaipur')
            ->assertDontSee('0 Neighborhoods Covered');
    }

    /* ---------------- calendar field label ---------------- */

    public function test_the_calendar_field_is_labelled_source_neutrally(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $property = Property::factory()->create(['host_id' => $host->id]);

        foreach (['/host/properties/create', '/host/properties/'.$property->id.'/edit'] as $url) {
            $response = $this->actingAs($host)->get($url)->assertOk();

            $response->assertSee('External Calendar / iCal URL');
            $response->assertDontSee('Airbnb Calendar URL');
            $response->assertDontSee('airbnb.com/calendar/ical', false);
        }
    }

    /* ---------------- Verified badge ---------------- */

    public function test_verified_tracks_admin_approval_and_nothing_else(): void
    {
        // is_verified set true by a seeder / manual edit, never approved.
        $unreviewed = Property::factory()->create([
            'listing_status' => Property::STATUS_PENDING,
            'is_verified'    => true,
        ]);
        $rejected = Property::factory()->create([
            'listing_status' => Property::STATUS_REJECTED,
            'is_verified'    => true,
        ]);
        // Approved, but the column was left behind.
        $approved = Property::factory()->live()->create(['is_verified' => false]);

        $this->assertFalse($unreviewed->isVerified());
        $this->assertFalse($rejected->isVerified());
        $this->assertTrue($approved->isVerified());
    }

    public function test_an_approved_listing_shows_the_verified_badge(): void
    {
        $property = Property::factory()->live()->create(['is_verified' => false]);

        $this->get('/property/'.$property->id)->assertOk()->assertSee('Verified Listing');
    }
}
