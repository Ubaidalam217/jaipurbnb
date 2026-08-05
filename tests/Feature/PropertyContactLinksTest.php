<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Covers Property::whatsappUrl() / callUrl() and their rendering on
 * /browse and /property/{id} via the shared contact-buttons partial.
 */
class PropertyContactLinksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return iterable<string, array{string}>
     */
    public static function messyPhoneFormats(): iterable
    {
        yield 'plus and spaces'     => ['+91 98765 43210'];
        yield 'dashes, no country'  => ['98765-43210'];
        yield 'dash-separated 91'   => ['91-9876543210'];
        yield 'already bare 10-digit' => ['9876543210'];
    }

    #[DataProvider('messyPhoneFormats')]
    public function test_whatsapp_and_call_urls_normalise_every_phone_format(string $rawPhone): void
    {
        $host = User::factory()->create(['phone_number' => $rawPhone]);
        $property = Property::factory()->create(['host_id' => $host->id, 'title' => 'Sunset Villa']);

        $this->assertSame(
            'https://wa.me/919876543210?text=Hi%2C+I+am+interested+in+Sunset+Villa+listed+on+JaipurBnB.+Can+you+share+more+details%3F',
            $property->whatsappUrl()
        );
        $this->assertSame('tel:+919876543210', $property->callUrl());
    }

    public function test_the_message_urlencodes_special_characters_in_the_title(): void
    {
        $host = User::factory()->create(['phone_number' => '9876543210']);
        $property = Property::factory()->create(['host_id' => $host->id, 'title' => "Cozy 2BR, Walled City"]);

        $this->assertStringContainsString(
            'interested+in+Cozy+2BR%2C+Walled+City+listed',
            $property->whatsappUrl()
        );
    }

    public function test_urls_are_null_when_the_host_has_no_phone_number(): void
    {
        $host = User::factory()->create(['phone_number' => null]);
        $property = Property::factory()->create(['host_id' => $host->id]);

        $this->assertNull($property->whatsappUrl());
        $this->assertNull($property->callUrl());
    }

    public function test_the_single_property_page_renders_working_contact_links(): void
    {
        $host = User::factory()->create(['phone_number' => '9876543210']);
        $property = Property::factory()->live()->create(['host_id' => $host->id, 'title' => 'Sunset Villa']);

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $response->assertSee('https://wa.me/919876543210', false);
        $response->assertSee('tel:+919876543210', false);
        $response->assertSee('target="_blank"', false);
        $response->assertSee('data-lead-type="whatsapp_click"', false);
        $response->assertSee('data-lead-type="call_click"', false);
        $response->assertSee('data-property-id="'.$property->id.'"', false);
    }

    public function test_the_single_property_page_shows_a_fallback_when_the_host_has_no_phone(): void
    {
        $host = User::factory()->create(['phone_number' => null]);
        $property = Property::factory()->live()->create(['host_id' => $host->id]);

        $this->get(route('properties.show', $property))
            ->assertOk()
            ->assertSee('Contact info unavailable');
    }

    public function test_the_property_page_stamps_its_id_for_profile_view_tracking(): void
    {
        $property = Property::factory()->live()->create();

        $this->get(route('properties.show', $property))
            ->assertOk()
            ->assertSee('data-property-id="'.$property->id.'"', false);
    }

    public function test_browse_cards_render_small_contact_buttons(): void
    {
        $host = User::factory()->create(['phone_number' => '9876543210']);
        $property = Property::factory()->live()->create(['host_id' => $host->id, 'title' => 'Small Button Stay']);

        $response = $this->get('/browse');

        $response->assertOk();
        $response->assertSee('Small Button Stay');
        $response->assertSee('jb-contact-row--sm', false);
        $response->assertSee('https://wa.me/919876543210', false);
    }

    public function test_the_contact_button_css_is_emitted_only_once_per_page_with_many_cards(): void
    {
        $host = User::factory()->create(['phone_number' => '9876543210']);
        Property::factory()->live()->count(3)->create(['host_id' => $host->id]);

        $response = $this->get('/browse');

        $response->assertOk();
        $this->assertSame(
            1,
            substr_count($response->getContent(), '.jb-contact-row {'),
            '@once should keep the contact-buttons <style> block from repeating per card.'
        );
    }

    public function test_the_call_button_does_not_open_a_new_tab(): void
    {
        $host = User::factory()->create(['phone_number' => '9876543210']);
        $property = Property::factory()->live()->create(['host_id' => $host->id]);

        $html = $this->get(route('properties.show', $property))->assertOk()->getContent();

        // A tel: URL is handed to the OS rather than loaded as a document,
        // so target="_blank" strands an empty tab on desktop.
        preg_match('/<a[^>]*jb-contact-btn--call[^>]*>/', $html, $call);
        $this->assertNotEmpty($call, 'Call button anchor not found.');
        $this->assertStringNotContainsString('target=', $call[0]);

        // WhatsApp is a real https:// page and should still open in a new tab.
        preg_match('/<a[^>]*jb-contact-btn--whatsapp[^>]*>/', $html, $whatsapp);
        $this->assertNotEmpty($whatsapp, 'WhatsApp button anchor not found.');
        $this->assertStringContainsString('target="_blank"', $whatsapp[0]);
        $this->assertStringContainsString('rel="noopener noreferrer"', $whatsapp[0]);
    }

    public function test_browse_card_buttons_are_rendered_outside_the_templates_content_area(): void
    {
        // The template's `.content-area a` rule forces display:inline-block,
        // which silently disables the buttons' flex centring. Keeping the
        // contact row outside .content-area is what makes the CSS work, so
        // guard the structure rather than just the styling.
        $host = User::factory()->create(['phone_number' => '9876543210']);
        Property::factory()->live()->create(['host_id' => $host->id, 'title' => 'Structure Stay']);

        $html = $this->get('/browse')->assertOk()->getContent();

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);

        $this->assertSame(
            0,
            $xpath->query("//div[contains(@class,'content-area')]//div[contains(@class,'jb-contact-row')]")->length,
            'Contact buttons must NOT be nested inside .content-area.'
        );

        $this->assertGreaterThan(
            0,
            $xpath->query("//div[contains(@class,'jb-card-contact')]//div[contains(@class,'jb-contact-row')]")->length,
            'Contact buttons should live in the .jb-card-contact sibling wrapper.'
        );
    }
}
