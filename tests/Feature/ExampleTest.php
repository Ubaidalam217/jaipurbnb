<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // The homepage stopped being a static view: it now queries properties for
    // the featured card and the live-listing count, so this needs a schema.
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * With nothing published the featured card must fall back to /browse
     * rather than blowing up on a null $featured.
     */
    public function test_the_homepage_renders_with_no_live_listings(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Browse Jaipur stays');
    }
}
