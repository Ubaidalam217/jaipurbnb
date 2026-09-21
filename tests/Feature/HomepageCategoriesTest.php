<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The "Find your stay in Jaipur" category cards on the homepage.
 *
 * These exist because the cards fail SILENTLY when they are wrong. /browse
 * sanitises rather than validates (see the class docblock on
 * PropertyController): an unrecognised ?stay_type= is dropped and the page
 * renders the full catalogue with a 200. So a card pointing at a slug like
 * "?stay_type=haveli" looks completely healthy - right status, listings on
 * screen - while actually applying no filter at all. Nothing short of
 * asserting that a non-matching listing is ABSENT catches that.
 */
class HomepageCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Every card, with a listing that must match and one that must not.
     *
     * @return array<string, array{0: string, 1: array<string, string>, 2: array<string, string>}>
     */
    public static function categoryProvider(): array
    {
        return [
            'Havelis' => ['Havelis',
                ['stay_type' => 'Heritage Haveli / Fort Stay'],
                ['stay_type' => 'Backpacker Hostel']],
            'Villas' => ['Villas',
                ['stay_type' => 'Luxury Villa / Farmhouse'],
                ['stay_type' => 'Backpacker Hostel']],
            'Apartments' => ['Apartments',
                ['stay_type' => 'Boutique Apartment'],
                ['stay_type' => 'Backpacker Hostel']],
            'Homestays' => ['Homestays',
                ['stay_type' => 'Homestay / Guest House'],
                ['stay_type' => 'Backpacker Hostel']],
            'C-Scheme' => ['C-Scheme',
                ['neighborhood' => 'C-Scheme'],
                ['neighborhood' => 'Mansarovar']],
            'Old City' => ['Old City',
                ['neighborhood' => 'Walled City'],
                ['neighborhood' => 'Mansarovar']],
        ];
    }

    /**
     * Pulls the href the homepage actually rendered for a card, so the test
     * follows the real link rather than a URL restated here - restating it
     * would let the page and the test drift apart and still pass.
     */
    private function hrefFor(string $label): string
    {
        $html = $this->get('/')->assertStatus(200)->getContent();

        $pattern = '/<a class="jb-cat" href="([^"]+)">(?:(?!<\/a>).)*?'
            . 'jb-cat__name">' . preg_quote($label, '/') . '</s';

        $this->assertMatchesRegularExpression(
            $pattern,
            $html,
            "No category card labelled \"{$label}\" was rendered on the homepage."
        );

        preg_match($pattern, $html, $m);

        return html_entity_decode($m[1], ENT_QUOTES);
    }

    /**
     * @param  array<string, string>  $matching
     * @param  array<string, string>  $other
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('categoryProvider')]
    public function test_each_category_card_links_to_a_genuinely_filtered_browse_page(
        string $label,
        array $matching,
        array $other
    ): void {
        Property::factory()->live()->create($matching + ['title' => 'Should Appear Here']);
        Property::factory()->live()->create($other + ['title' => 'Should Be Filtered Out']);

        $this->get($this->hrefFor($label))
            ->assertStatus(200)
            ->assertSee('Should Appear Here')
            // The assertion that actually matters: if the query param were a
            // slug the controller does not recognise, this listing would
            // still be on the page.
            ->assertDontSee('Should Be Filtered Out');
    }

    public function test_every_card_uses_a_value_the_browse_controller_recognises(): void
    {
        $allowed = array_merge(Property::STAY_TYPES, Property::NEIGHBORHOODS);

        foreach (array_keys(self::categoryProvider()) as $label) {
            $query = parse_url($this->hrefFor($label), PHP_URL_QUERY);
            parse_str((string) $query, $params);

            $this->assertNotEmpty($params, "Category \"{$label}\" links to /browse with no filter at all.");

            foreach ($params as $key => $value) {
                $this->assertContains($key, ['stay_type', 'neighborhood']);
                $this->assertContains(
                    $value,
                    $allowed,
                    "Category \"{$label}\" filters on \"{$value}\", which is not in "
                    . 'Property::STAY_TYPES or ::NEIGHBORHOODS, so /browse will silently ignore it.'
                );
            }
        }
    }

    public function test_the_section_renders_its_heading_and_all_six_cards(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Find your stay in Jaipur')
            ->assertSee("Explore verified stays across Jaipur's most sought-after locations", false)
            ->assertSeeInOrder(['Havelis', 'Villas', 'Apartments', 'Homestays', 'C-Scheme', 'Old City']);
    }

    public function test_a_card_shows_a_live_count_and_falls_back_to_a_blurb_at_zero(): void
    {
        Property::factory()->count(2)->live()->create(['stay_type' => 'Luxury Villa / Farmhouse']);

        $html = $this->get('/')->assertStatus(200)->getContent();

        $this->assertStringContainsString('2 stays', $html);
        // Nothing is listed as a haveli, so that card must not claim "0 stays".
        $this->assertStringNotContainsString('0 stays', $html);
        $this->assertStringContainsString('Heritage courtyards', $html);
    }
}
