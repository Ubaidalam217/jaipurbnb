<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

/**
 * Step 1 of password reset: ask for an email, send a signed reset link.
 *
 * Uses Laravel's Password broker and the password_reset_tokens table that
 * ships in the default create_users_table migration - we only hand-roll
 * the controllers and views, not the token handling.
 *
 * MAIL_MAILER=log in this environment, so the reset link is written to
 * storage/logs/laravel.log rather than delivered. Real SMTP comes from the
 * client before launch.
 */
class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(
            ['email' => ['required', 'email', 'max:100']],
            [],
            ['email' => 'email address']
        );

        $status = Password::sendResetLink($request->only('email'));

        // Deliberately report the same outcome whether or not the address is
        // registered. Saying "we have no account for that email" turns this
        // public form into an account-enumeration oracle. A genuine throttle
        // hit is the one case worth surfacing, so the guest knows to wait.
        if ($status === Password::RESET_THROTTLED) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Please wait a moment before requesting another reset link.');
        }

        return back()->with('status', 'If that email is registered, a password reset link is on its way.');
    }
}
