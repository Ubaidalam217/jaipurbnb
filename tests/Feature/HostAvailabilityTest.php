<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyAvailability;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Covers the host calendar page and its toggle endpoint.
 *
 * The invariant under test: a host may only ever change source='manual'
 * rows on their OWN listing, for dates that are not in the past.
 */
class HostAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private User $host;

    private Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->host = User::factory()->create(['role' => User::ROLE_HOST]);
        $this->property = Property::factory()->live()->create(['host_id' => $this->host->id]);
    }

    private function toggle(string $date, ?Property $property = null): \Illuminate\Testing\TestResponse
    {
        return $this->postJson(
            route('host.properties.availability.toggle', $property ?? $this->property),
            ['date' => $date]
        );
    }

    /* ---------------- page ---------------- */

    public function test_a_host_can_open_their_own_calendar(): void
    {
        $response = $this->actingAs($this->host)
            ->get(route('host.properties.availability', $this->property));

        $response->assertOk();
        $response->assertSee($this->property->title);
        $response->assertSee('jb-cal--interactive', false);
        $response->assertSee('data-toggle-url', false);
        $response->assertSee('Airbnb-synced (locked)');
    }

    public function test_the_calendar_404s_for_someone_elses_listing(): void
    {
        $intruder = User::factory()->create(['role' => User::ROLE_HOST]);

        $this->actingAs($intruder)
            ->get(route('host.properties.availability', $this->property))
            ->assertNotFound();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('host.properties.availability', $this->property))
            ->assertRedirect(route('login'));
    }

    public function test_past_dates_are_not_clickable(): void
    {
        $html = $this->actingAs($this->host)
            ->get(route('host.properties.availability', $this->property))
            ->assertOk()
            ->getContent();

        // Every past cell must be a span, never a button.
        preg_match_all('/<button[^>]*jb-cal__day--past/', $html, $matches);
        $this->assertCount(0, $matches[0]);
    }

    /* ---------------- toggle ---------------- */

    public function test_toggling_a_free_date_blocks_it_as_a_manual_row(): void
    {
        $date = now()->addDays(4)->toDateString();

        $response = $this->actingAs($this->host)->toggle($date);

        $response->assertOk()->assertJson([
            'ok'      => true,
            'date'    => $date,
            'status'  => PropertyAvailability::STATUS_BLOCKED,
            'blocked' => true,
        ]);

        $this->assertDatabaseHas('property_availability', [
            'property_id'   => $this->property->id,
            'calendar_date' => $date,
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);
    }

    public function test_toggling_a_blocked_date_opens_it_back_up(): void
    {
        $date = now()->addDays(4)->toDateString();

        $this->actingAs($this->host)->toggle($date)->assertOk();
        $response = $this->actingAs($this->host)->toggle($date);

        $response->assertOk()->assertJson([
            'status'  => PropertyAvailability::STATUS_AVAILABLE,
            'blocked' => false,
        ]);

        // The row is kept (status flipped), not deleted - the iCal sync
        // relies on rows being addressable by (property, date).
        $this->assertDatabaseCount('property_availability', 1);
        $this->assertDatabaseHas('property_availability', [
            'calendar_date' => $date,
            'status'        => PropertyAvailability::STATUS_AVAILABLE,
        ]);
    }

    public function test_today_can_be_blocked_but_yesterday_cannot(): void
    {
        $this->actingAs($this->host)->toggle(now()->toDateString())->assertOk();

        $this->actingAs($this->host)
            ->toggle(now()->subDay()->toDateString())
            ->assertStatus(422)
            ->assertJsonValidationErrors('date');

        $this->assertDatabaseCount('property_availability', 1);
    }

    public function test_a_host_cannot_unblock_an_airbnb_synced_date(): void
    {
        $date = now()->addDays(7)->toDateString();

        PropertyAvailability::create([
            'property_id'   => $this->property->id,
            'calendar_date' => $date,
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_AIRBNB,
        ]);

        $response = $this->actingAs($this->host)->toggle($date);

        $response->assertStatus(422)->assertJson(['ok' => false]);
        $response->assertJsonPath('message', 'This date is blocked by your Airbnb calendar and cannot be changed here.');

        // Untouched.
        $this->assertDatabaseHas('property_availability', [
            'calendar_date' => $date,
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_AIRBNB,
        ]);
    }

    public function test_a_host_cannot_toggle_a_booked_date(): void
    {
        $date = now()->addDays(8)->toDateString();

        PropertyAvailability::create([
            'property_id'   => $this->property->id,
            'calendar_date' => $date,
            'status'        => PropertyAvailability::STATUS_BOOKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);

        $this->actingAs($this->host)->toggle($date)->assertStatus(422);

        $this->assertDatabaseHas('property_availability', [
            'calendar_date' => $date,
            'status'        => PropertyAvailability::STATUS_BOOKED,
        ]);
    }

    public function test_a_host_cannot_toggle_dates_on_someone_elses_listing(): void
    {
        $intruder = User::factory()->create(['role' => User::ROLE_HOST]);

        $this->actingAs($intruder)
            ->toggle(now()->addDays(3)->toDateString())
            ->assertNotFound();

        $this->assertDatabaseCount('property_availability', 0);
    }

    public function test_a_guest_cannot_toggle_dates(): void
    {
        $this->toggle(now()->addDays(3)->toDateString())->assertUnauthorized();

        $this->assertDatabaseCount('property_availability', 0);
    }

    public function test_a_malformed_date_is_rejected(): void
    {
        $this->actingAs($this->host)->toggle('not-a-date')->assertStatus(422);
        $this->actingAs($this->host)->toggle('15/08/2026')->assertStatus(422);

        $this->assertDatabaseCount('property_availability', 0);
    }

    /* ---------------- end to end ---------------- */

    public function test_a_date_blocked_by_the_host_shows_as_blocked_to_guests(): void
    {
        $date = now()->addDays(9);

        $this->actingAs($this->host)->toggle($date->toDateString())->assertOk();

        // Sign out before checking the public page.
        auth()->logout();

        $this->get(route('properties.show', $this->property))
            ->assertOk()
            ->assertSee($date->format('j F Y').' — blocked', false);
    }
}
