<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Step 2 of password reset: accept the emailed token and set a new password.
 *
 * Password rules mirror RegisterRequest (min 8, confirmed) so a host cannot
 * end up with a password the signup form would have rejected.
 */
class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required', 'string'],
            'email'    => ['required', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [], ['email' => 'email address']);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                // The cast on User hashes this; forceFill keeps it off the
                // mass-assignment path.
                $user->forceFill([
                    'password'       => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('status', 'Your password has been reset. Sign in with your new password.');
        }

        // Invalid or expired token, or an email that does not match the token.
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'That reset link is invalid or has expired. Please request a new one.']);
    }
}
