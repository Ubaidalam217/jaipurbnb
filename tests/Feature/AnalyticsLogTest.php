<?php

namespace Tests\Feature;

use App\Models\LeadAnalytic;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Covers POST /api/analytics/log, the sink for navigator.sendBeacon()
 * calls fired by main.js. sendBeacon has no response handler, so the
 * contract this endpoint must honour is: ALWAYS 200, regardless of
 * whether anything was actually recorded.
 */
class AnalyticsLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_a_whatsapp_click_for_a_visible_property(): void
    {
        $property = Property::factory()->live()->create();

        $response = $this->postJson('/api/analytics/log', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_WHATSAPP,
        ]);

        $response->assertOk()->assertExactJson(['ok' => true]);
        $this->assertDatabaseHas('lead_analytics', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_WHATSAPP,
        ]);
    }

    public function test_it_logs_a_call_click(): void
    {
        $property = Property::factory()->live()->create();

        $this->postJson('/api/analytics/log', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_CALL,
        ])->assertOk();

        $this->assertDatabaseHas('lead_analytics', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_CALL,
        ]);
    }

    public function test_it_logs_a_profile_view(): void
    {
        $property = Property::factory()->live()->create();

        $this->postJson('/api/analytics/log', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_PROFILE_VIEW,
        ])->assertOk();

        $this->assertDatabaseHas('lead_analytics', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_PROFILE_VIEW,
        ]);
    }

    public function test_it_silently_ignores_an_unrecognised_lead_type(): void
    {
        $property = Property::factory()->live()->create();

        $this->postJson('/api/analytics/log', [
            'property_id' => $property->id,
            'lead_type'   => 'not_a_real_type',
        ])->assertOk()->assertExactJson(['ok' => true]);

        $this->assertDatabaseCount('lead_analytics', 0);
    }

    public function test_it_silently_ignores_a_property_that_does_not_exist(): void
    {
        $this->postJson('/api/analytics/log', [
            'property_id' => 999999,
            'lead_type'   => LeadAnalytic::TYPE_WHATSAPP,
        ])->assertOk()->assertExactJson(['ok' => true]);

        $this->assertDatabaseCount('lead_analytics', 0);
    }

    public function test_it_silently_ignores_a_pending_property(): void
    {
        $property = Property::factory()->create(); // default state: pending, not visible

        $this->postJson('/api/analytics/log', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_PROFILE_VIEW,
        ])->assertOk();

        $this->assertDatabaseCount('lead_analytics', 0);
    }

    public function test_it_silently_ignores_an_expired_property(): void
    {
        $property = Property::factory()->create([
            'listing_status' => Property::STATUS_APPROVED,
            'is_visible'     => false,
        ]);

        $this->postJson('/api/analytics/log', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_CALL,
        ])->assertOk();

        $this->assertDatabaseCount('lead_analytics', 0);
    }

    public function test_missing_fields_return_200_rather_than_a_validation_error(): void
    {
        $this->postJson('/api/analytics/log', [])
            ->assertOk()
            ->assertExactJson(['ok' => true]);
    }

    public function test_it_is_reachable_without_authentication_or_a_csrf_token(): void
    {
        $this->assertGuest();
        $property = Property::factory()->live()->create();

        $this->postJson('/api/analytics/log', [
            'property_id' => $property->id,
            'lead_type'   => LeadAnalytic::TYPE_PROFILE_VIEW,
        ])->assertOk();
    }
}
