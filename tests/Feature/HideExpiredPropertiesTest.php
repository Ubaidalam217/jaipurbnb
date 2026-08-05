<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * Covers the daily expiry sweep (php artisan properties:hide-expired).
 *
 * The contract under test: the command may only ever flip is_visible
 * from true to false, for approved-and-expired listings. It must not
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

    public function test_it_ignores_listings_with_no_subscription_expiry(): void
    {
        $property = Property::factory()->live()->create(['subscription_expiry' => null]);

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
            ->expectsOutputToContain('Hid 3 expired listings.')
            ->assertSuccessful();
    }

    public function test_it_reports_zero_when_nothing_has_expired(): void
    {
        Property::factory()->live()->create();

        $this->artisan('properties:hide-expired')
            ->expectsOutputToContain('Hid 0 expired listings.')
            ->assertSuccessful();
    }

    public function test_the_daily_midnight_schedule_is_registered(): void
    {
        $events = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events())
            ->filter(fn ($event) => str_contains($event->command ?? '', 'properties:hide-expired'));

        $this->assertCount(1, $events, 'properties:hide-expired is not scheduled.');
        $this->assertSame('0 0 * * *', $events->first()->expression);
    }
}
