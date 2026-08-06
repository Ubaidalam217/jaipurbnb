<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

/**
 * Hand-rolled password reset over Laravel's Password broker.
 *
 * The broker and the password_reset_tokens table do the token work; only the
 * controllers and views are ours, so these tests focus on routing, the
 * no-enumeration response, and that a reset actually changes the password.
 */
class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    private function host(string $email = 'host@example.com'): User
    {
        return User::factory()->create([
            'email'    => $email,
            'password' => 'original-password',
            'role'     => User::ROLE_HOST,
        ]);
    }

    public function test_the_forgot_password_page_loads(): void
    {
        $this->get('/forgot-password')
            ->assertStatus(200)
            ->assertSee('Forgot your password?');
    }

    public function test_the_login_page_links_to_it(): void
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee(route('password.request'));
    }

    public function test_a_reset_link_is_sent_to_a_registered_address(): void
    {
        Notification::fake();
        $user = $this->host();

        $this->post('/forgot-password', ['email' => $user->email])
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_an_unknown_address_gets_the_same_response(): void
    {
        Notification::fake();

        // No account enumeration: an unregistered address must not be
        // distinguishable from a registered one.
        $this->post('/forgot-password', ['email' => 'nobody@example.com'])
            ->assertRedirect()
            ->assertSessionHas('status');

        Notification::assertNothingSent();
    }

    public function test_an_invalid_email_is_rejected(): void
    {
        $this->post('/forgot-password', ['email' => 'not-an-email'])
            ->assertSessionHasErrors('email');
    }

    public function test_the_reset_form_loads_from_the_emailed_token(): void
    {
        $user  = $this->host();
        $token = Password::createToken($user);

        $this->get('/reset-password/'.$token.'?email='.urlencode($user->email))
            ->assertStatus(200)
            ->assertSee('Choose a new password');
    }

    public function test_a_valid_token_changes_the_password(): void
    {
        $user  = $this->host();
        $token = Password::createToken($user);

        $this->post('/reset-password', [
            'token'                 => $token,
            'email'                 => $user->email,
            'password'              => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('brand-new-password', $user->fresh()->password));
    }

    public function test_the_new_password_signs_in_and_the_old_one_does_not(): void
    {
        $user  = $this->host();
        $token = Password::createToken($user);

        $this->post('/reset-password', [
            'token'                 => $token,
            'email'                 => $user->email,
            'password'              => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'original-password'])
            ->assertSessionHasErrors();
        $this->assertGuest();

        $this->post('/login', ['email' => $user->email, 'password' => 'brand-new-password']);
        $this->assertAuthenticatedAs($user->fresh());
    }

    public function test_a_bogus_token_is_refused(): void
    {
        $user = $this->host();

        $this->post('/reset-password', [
            'token'                 => 'not-a-real-token',
            'email'                 => $user->email,
            'password'              => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
        ])->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('original-password', $user->fresh()->password));
    }

    public function test_the_password_must_be_confirmed_and_long_enough(): void
    {
        $user  = $this->host();
        $token = Password::createToken($user);

        $this->post('/reset-password', [
            'token'                 => $token,
            'email'                 => $user->email,
            'password'              => 'short',
            'password_confirmation' => 'mismatch',
        ])->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('original-password', $user->fresh()->password));
    }

    public function test_a_signed_in_user_is_redirected_away(): void
    {
        // The reset routes sit inside the guest middleware group.
        $this->actingAs($this->host())
            ->get('/forgot-password')
            ->assertRedirect();
    }
}
