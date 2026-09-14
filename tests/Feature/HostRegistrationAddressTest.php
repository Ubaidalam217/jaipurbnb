<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The optional host address fields added to /register. Optional means
 * optional: signup must still succeed with none of them filled in.
 */
class HostRegistrationAddressTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'full_name'             => 'Test Host',
            'email'                 => 'testhost@example.com',
            'phone_number'          => '9876500001',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ], $overrides);
    }

    public function test_registration_succeeds_without_any_address_fields(): void
    {
        $this->post('/register', $this->payload())->assertRedirect(route('host.dashboard'));

        $user = User::where('email', 'testhost@example.com')->firstOrFail();
        $this->assertNull($user->host_address);
        $this->assertNull($user->host_city);
    }

    public function test_registration_saves_the_address_fields_when_provided(): void
    {
        $this->post('/register', $this->payload([
            'host_address' => '10 Palace Road',
            'host_city'    => 'Jaipur',
            'host_state'   => 'Rajasthan',
            'host_pincode' => '302001',
        ]))->assertRedirect(route('host.dashboard'));

        $user = User::where('email', 'testhost@example.com')->firstOrFail();
        $this->assertSame('10 Palace Road', $user->host_address);
        $this->assertSame('Jaipur', $user->host_city);
        $this->assertSame('Rajasthan', $user->host_state);
        $this->assertSame('302001', $user->host_pincode);
    }
}
