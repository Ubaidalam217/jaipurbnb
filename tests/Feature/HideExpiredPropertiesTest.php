<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * Covers the daily expiry sweep (php artisan properties:hide-expired).
 *
 * The contract under test: for approved listings, the command flips
 * is_visible to false once BOTH the paid subscription and the host's
 * Founding Host promo (60 free days from registration, see
 * User::isFoundingHostActive()) have lapsed or never existed - a
 * listing stays visible as long as EITHER cover is active. It also
 * flips is_visible to true for an approved-but-unpublished listing
 * whose host is still inside their Founding Host window. It must not
 * touch listing_status and must not delete rows.
 */
class HideExpiredPropertiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_hides_a_listing_whose_subscription_expired_yesterday(): void
    {
        $property = Property::factory()->expired()->create();

        $this->artisan('properties:hide-expired')->assertSuccessful();

        $property->refresh();
        $this->assertFalse($property->is_visible);
    }

    public function test_it_preserves_listing_status_and_the_row_itself(): void
    {
        $property = Property::factory()->expired()->create(['title' => 'Expired Haveli']);

        $this->artisan('properties:hide-expired');

        $property->refresh();
        $this->assertSame(Property::STATUS_APPROVED, $property->listing_status);
        $this->assertSame('Expired Haveli', $property->title);
        $this->assertDatabaseCount('properties', 1);
    }

    public function test_it_leaves_a_listing_that_expires_in_the_future_alone(): void
    {
        $property = Property::factory()->live()->create();

        $this->artisan('properties:hide-expired');

        $this->assertTrue($property->refresh()->is_visible);
    }

    public function test_it_leaves_a_listing_expiring_today_alone(): void
    {
        // The last paid day is not over yet - tomorrow's run takes it down.
        $property = Property::factory()->live()->create([
            'subscription_expiry' => now()->toDateString(),
        ]);

        $this->artisan('properties:hide-expired');

        $this->assertTrue($property->refresh()->is_visible);
    }

    public function test_it_hides_a_listing_with_no_subscription_and_no_founding_host(): void
    {
        // host_id comes from a plain User::factory(), which leaves
        // founding_host_expires_at null - no promo cover either.
        $property = Property::factory()->live()->create(['subscription_expiry' => null]);

        $this->artisan('properties:hide-expired');

        $this->assertFalse($property->refresh()->is_visible);
    }

    public function test_it_leaves_a_listing_alive_via_an_active_founding_host_with_no_subscription(): void
    {
        $host = User::factory()->create(['founding_host_expires_at' => now()->addDays(10)]);
        $property = Property::factory()->live()->create([
            'host_id'             => $host->id,
            'subscription_expiry' => null,
        ]);

        $this->artisan('properties:hide-expired');

        $this->assertTrue($property->refresh()->is_visible);
    }

    public function test_it_hides_a_listing_once_both_subscription_and_founding_host_have_lapsed(): void
    {
        $host = User::factory()->create(['founding_host_expires_at' => now()->subDay()]);
        $property = Property::factory()->expired()->create(['host_id' => $host->id]);

        $this->artisan('properties:hide-expired');

        $this->assertFalse($property->refresh()->is_visible);
    }

    public function test_it_auto_publishes_an_approved_listing_still_inside_the_founding_host_window(): void
    {
        $host = User::factory()->create(['founding_host_expires_at' => now()->addDays(30)]);
        $property = Property::factory()->create([
            'host_id'             => $host->id,
            'listing_status'      => Property::STATUS_APPROVED,
            'is_visible'          => false,
            'subscription_expiry' => null,
        ]);

        $this->artisan('properties:hide-expired');

        $this->assertTrue($property->refresh()->is_visible);
    }

    public function test_it_logs_how_many_listings_it_hid(): void
    {
        Property::factory()->expired()->count(3)->create();
        // Already hidden - must not be counted twice on the next run.
        Property::factory()->expired()->create(['is_visible' => false]);

        Log::shouldReceive('info')
            ->once()
            ->withArgs(fn (string $message, array $context) => $context['hidden_count'] === 3);

        $this->artisan('properties:hide-expired')
            ->expectsOutputToContain('hid 3 expired listings.')
            ->assertSuccessful();
    }

    public function test_it_reports_zero_when_nothing_has_expired(): void
    {
        Property::factory()->live()->create();

        $this->artisan('properties:hide-expired')
            ->expectsOutputToContain('hid 0 expired listings.')
            ->assertSuccessful();
    }

    /**
     * Matches on the event description, not on $event->command.
     *
     * routes/console.php registers this through Schedule::call() rather than
     * Schedule::command(), because Hostinger disables proc_open and
     * Schedule::command() always forks a subprocess. A callback event has a
     * null ->command, so the ->name('properties:hide-expired') given at
     * registration - which lands in ->description - is what identifies it.
     */
    public function test_the_daily_midnight_schedule_is_registered(): void
    {
        $events = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events())
            ->filter(fn ($event) => str_contains($event->description ?? '', 'properties:hide-expired'));

        $this->assertCount(1, $events, 'properties:hide-expired is not scheduled.');
        $this->assertSame('0 0 * * *', $events->first()->expression);
    }

    /**
     * The scheduler must not shell out on this deployment - see above.
     */
    public function test_no_scheduled_task_forks_a_subprocess(): void
    {
        $forking = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events())
            ->reject(fn ($event) => $event instanceof \Illuminate\Console\Scheduling\CallbackEvent);

        $this->assertCount(
            0,
            $forking,
            'Schedule::command() needs proc_open, which is disabled on Hostinger. Use Schedule::call(fn () => Artisan::call(...)) instead.'
        );
    }
}
