<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_the_shipped_default_is_an_obvious_placeholder(): void
    {
        $this->assertSame('+91 00000 00000', config('contact.phone'));
        $this->assertSame('+910000000000', config('contact.phone_tel'));
    }

    /* ---------------- subscription state vs listing title ---------------- */

    public function test_the_listing_title_never_carries_subscription_wording(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        // Approved, paid once, lapsed - the state that renders the
        // "Renew Subscription" call to action.
        Property::factory()->expired()->create([
            'host_id' => $host->id,
            'title'   => 'Nahargarh Heritage Retreat',
        ]);

        $html = $this->actingAs($host)->get('/host/properties')->assertOk()->getContent();

        // The CTA is still offered - it just lives outside the title.
        $this->assertStringContainsString('Renew Subscription', $html);

        preg_match_all('/<h2 class="jb-row__title">(.*?)<\/h2>/s', $html, $titles);

        $this->assertNotEmpty($titles[1], 'No listing title rendered.');

        foreach ($titles[1] as $title) {
            $this->assertSame('Nahargarh Heritage Retreat', trim($title));
        }
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
