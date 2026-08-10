<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // 'role' is intentionally never passed: it is not fillable and the
        // users table defaults it to 'host'. Passing request input here
        // would be a privilege-escalation hole.
        $user = User::create([
            'name'         => $validated['full_name'],
            'email'        => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password'     => $validated['password'], // hashed by the model cast
        ]);

        // Founding Host promo: every new host gets 60 days of free listing
        // visibility, independent of the paid subscription.
        $user->founding_host_expires_at = now()->addDays(60);
        $user->save();

        Auth::login($user);

        // Guard against session fixation - issue a fresh session id now
        // that the request is authenticated.
        $request->session()->regenerate();

        return redirect()->route('host.dashboard')
            ->with('status', 'Welcome to JaipurBnB, '.$user->name.'!');
    }
}
