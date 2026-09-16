<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\PropertyAvailability;
use App\Models\User;
use App\Support\AvailabilityCalendar;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Covers the shared 3-month grid builder and the public read-only
 * calendar on /property/{id}.
 */
class AvailabilityCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_builds_three_months_starting_from_the_current_month(): void
    {
        $property = Property::factory()->live()->create();

        $calendar = AvailabilityCalendar::build($property, CarbonImmutable::parse('2026-08-15'));

        $this->assertCount(3, $calendar);
        $this->assertSame(['August 2026', 'September 2026', 'October 2026'], array_column($calendar, 'label'));
        $this->assertCount(31, $calendar[0]['days']);
        $this->assertCount(30, $calendar[1]['days']);
        $this->assertCount(31, $calendar[2]['days']);
    }

    public function test_leading_blanks_line_the_first_day_up_under_its_weekday(): void
    {
        $property = Property::factory()->live()->create();

        // 1 Aug 2026 is a Saturday (index 6), 1 Sep 2026 is a Tuesday (2).
        $calendar = AvailabilityCalendar::build($property, CarbonImmutable::parse('2026-08-15'));

        $this->assertSame(6, $calendar[0]['leading']);
        $this->assertSame(2, $calendar[1]['leading']);
    }

    public function test_a_date_with_no_record_defaults_to_available(): void
    {
        $property = Property::factory()->live()->create();

        $calendar = AvailabilityCalendar::build($property, CarbonImmutable::parse('2026-08-15'));

        $this->assertDatabaseCount('property_availability', 0);
        foreach ($calendar[1]['days'] as $day) {
            $this->assertTrue($day['is_available'], $day['date'].' should default to available.');
            $this->assertFalse($day['is_locked']);
        }
    }

    public function test_blocked_and_past_dates_are_flagged(): void
    {
        $today = CarbonImmutable::parse('2026-08-15');
        $property = Property::factory()->live()->create();

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => '2026-08-20',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);

        $days = collect($this->build($property, $today))->keyBy('date');

        $this->assertFalse($days['2026-08-20']['is_available']);
        $this->assertFalse($days['2026-08-20']['is_locked'], 'A manual block stays editable.');
        $this->assertTrue($days['2026-08-01']['is_past']);
        $this->assertFalse($days['2026-08-15']['is_past'], 'Today is not past.');
        $this->assertFalse($days['2026-08-16']['is_past']);
    }

    public function test_airbnb_synced_and_booked_dates_are_locked(): void
    {
        $today = CarbonImmutable::parse('2026-08-15');
        $property = Property::factory()->live()->create();

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => '2026-08-21',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_AIRBNB,
        ]);
        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => '2026-08-22',
            'status'        => PropertyAvailability::STATUS_BOOKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);

        $days = collect($this->build($property, $today))->keyBy('date');

        $this->assertTrue($days['2026-08-21']['is_locked']);
        $this->assertTrue($days['2026-08-22']['is_locked']);
        $this->assertFalse($days['2026-08-21']['is_available']);
        $this->assertFalse($days['2026-08-22']['is_available']);
    }

    public function test_it_ignores_another_properties_availability(): void
    {
        $today = CarbonImmutable::parse('2026-08-15');
        $mine = Property::factory()->live()->create();
        $theirs = Property::factory()->live()->create();

        PropertyAvailability::create([
            'property_id'   => $theirs->id,
            'calendar_date' => '2026-08-20',
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);

        $days = collect($this->build($mine, $today))->keyBy('date');

        $this->assertTrue($days['2026-08-20']['is_available']);
    }

    /* ---------------- public page ---------------- */

    public function test_the_public_property_page_renders_the_calendar(): void
    {
        $property = Property::factory()->live()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $response->assertSee('Check Available Dates');
        $response->assertSee('jb-cal__months', false);
        $response->assertSee(now()->format('F Y'));
        $response->assertSee(now()->addMonths(2)->format('F Y'));
        // Legend.
        $response->assertSee('jb-cal__swatch--available', false);
        $response->assertSee('jb-cal__swatch--blocked', false);
    }

    public function test_the_public_calendar_is_read_only(): void
    {
        $property = Property::factory()->live()->create();
        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => now()->addDays(3)->toDateString(),
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);

        $html = $this->get(route('properties.show', $property))->assertOk()->getContent();

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);

        // Attribute-level checks: the shared <style> block legitimately
        // mentions .jb-cal--interactive, so a plain string search would
        // match the CSS rather than an applied class.
        $this->assertSame(
            0,
            $xpath->query("//*[contains(@class,'jb-cal--interactive')]")->length,
            'The public calendar must not be marked interactive.'
        );
        $this->assertSame(
            0,
            $xpath->query('//*[@data-toggle-url]')->length,
            'The public page must not expose the toggle endpoint.'
        );

        // No day cell should be a button on the guest-facing page.
        preg_match_all('/<button[^>]*jb-cal__day/', $html, $buttons);
        $this->assertCount(0, $buttons[0], 'Public calendar cells must not be buttons.');
    }

    public function test_a_blocked_date_shows_as_blocked_on_the_public_calendar(): void
    {
        $property = Property::factory()->live()->create();
        $blocked = now()->addDays(5);

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => $blocked->toDateString(),
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_MANUAL,
        ]);

        $html = $this->get(route('properties.show', $property))->assertOk()->getContent();

        $this->assertMatchesRegularExpression(
            '/jb-cal__day jb-cal__day--blocked"[^>]*aria-label="'.preg_quote($blocked->format('j F Y'), '/').', blocked"/',
            $html
        );
    }

    public function test_an_airbnb_blocked_date_also_shows_as_unavailable_publicly(): void
    {
        $property = Property::factory()->live()->create();
        $blocked = now()->addDays(6);

        PropertyAvailability::create([
            'property_id'   => $property->id,
            'calendar_date' => $blocked->toDateString(),
            'status'        => PropertyAvailability::STATUS_BLOCKED,
            'source'        => PropertyAvailability::SOURCE_AIRBNB,
        ]);

        $this->get(route('properties.show', $property))
            ->assertOk()
            // The date is unavailable to a guest, but the REASON is withheld:
            // "blocked by Airbnb sync" would tell every visitor that this host
            // also lists on a competing marketplace. The host's own calendar
            // still spells it out - see the host test above.
            ->assertSee($blocked->format('j F Y').', unavailable', false)
            ->assertDontSee('Airbnb');
    }

    /* ---------------- helper ---------------- */

    /** @return list<array<string, mixed>> */
    private function build(Property $property, CarbonImmutable $today): array
    {
        return collect(AvailabilityCalendar::build($property, $today))
            ->flatMap(fn (array $month) => $month['days'])
            ->all();
    }
}
