<?php

namespace Tests\Feature;

use App\Models\LeadAnalytic;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostDashboardLeadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_30_day_lead_counts_by_type(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $property = Property::factory()->live()->create(['host_id' => $host->id]);

        LeadAnalytic::create(['property_id' => $property->id, 'lead_type' => LeadAnalytic::TYPE_PROFILE_VIEW, 'clicked_at' => now()->subDays(5)]);
        LeadAnalytic::create(['property_id' => $property->id, 'lead_type' => LeadAnalytic::TYPE_PROFILE_VIEW, 'clicked_at' => now()->subDays(10)]);
        LeadAnalytic::create(['property_id' => $property->id, 'lead_type' => LeadAnalytic::TYPE_WHATSAPP, 'clicked_at' => now()->subDays(2)]);
        LeadAnalytic::create(['property_id' => $property->id, 'lead_type' => LeadAnalytic::TYPE_CALL, 'clicked_at' => now()->subDays(1)]);
        // Outside the 30-day window - must not be counted.
        LeadAnalytic::create(['property_id' => $property->id, 'lead_type' => LeadAnalytic::TYPE_PROFILE_VIEW, 'clicked_at' => now()->subDays(40)]);

        $response = $this->actingAs($host)->get(route('host.dashboard'));

        $response->assertOk();
        $response->assertViewHas('profileViews30', 2);
        $response->assertViewHas('whatsappClicks30', 1);
        $response->assertViewHas('callClicks30', 1);
        $response->assertViewHas('totalLeads', 5);
    }

    public function test_dashboard_lists_the_last_5_properties_with_their_lead_counts(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $properties = collect();
        foreach (range(1, 6) as $i) {
            $properties->push(Property::factory()->live()->create([
                'host_id'    => $host->id,
                'title'      => "Stay {$i}",
                'created_at' => now()->subMinutes(6 - $i),
            ]));
        }
        $latest = $properties->last();

        LeadAnalytic::create(['property_id' => $latest->id, 'lead_type' => LeadAnalytic::TYPE_WHATSAPP]);
        LeadAnalytic::create(['property_id' => $latest->id, 'lead_type' => LeadAnalytic::TYPE_WHATSAPP]);
        LeadAnalytic::create(['property_id' => $latest->id, 'lead_type' => LeadAnalytic::TYPE_PROFILE_VIEW]);

        $response = $this->actingAs($host)->get(route('host.dashboard'));

        $response->assertOk();
        $recent = $response->viewData('recentProperties');

        $this->assertCount(5, $recent, 'Only 5 of the 6 properties should be listed.');
        $this->assertSame($latest->id, $recent->first()->id, 'The most recently created property should be first.');
        $this->assertSame(2, $recent->first()->whatsapp_clicks_count);
        $this->assertSame(1, $recent->first()->profile_views_count);
        $this->assertSame(0, $recent->first()->call_clicks_count);
        $response->assertSee('Stay 6');
    }

    public function test_dashboard_only_counts_the_signed_in_hosts_own_properties(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);
        $otherHost = User::factory()->create(['role' => User::ROLE_HOST]);

        $mine = Property::factory()->live()->create(['host_id' => $host->id]);
        $theirs = Property::factory()->live()->create(['host_id' => $otherHost->id]);

        LeadAnalytic::create(['property_id' => $mine->id, 'lead_type' => LeadAnalytic::TYPE_PROFILE_VIEW]);
        LeadAnalytic::create(['property_id' => $theirs->id, 'lead_type' => LeadAnalytic::TYPE_PROFILE_VIEW]);
        LeadAnalytic::create(['property_id' => $theirs->id, 'lead_type' => LeadAnalytic::TYPE_PROFILE_VIEW]);

        $response = $this->actingAs($host)->get(route('host.dashboard'));

        $response->assertViewHas('profileViews30', 1);
        $response->assertViewHas('totalLeads', 1);
    }

    public function test_dashboard_handles_a_host_with_no_properties_or_leads(): void
    {
        $host = User::factory()->create(['role' => User::ROLE_HOST]);

        $response = $this->actingAs($host)->get(route('host.dashboard'));

        $response->assertOk();
        $response->assertViewHas('profileViews30', 0);
        $response->assertViewHas('whatsappClicks30', 0);
        $response->assertViewHas('callClicks30', 0);
        $this->assertCount(0, $response->viewData('recentProperties'));
    }
}
