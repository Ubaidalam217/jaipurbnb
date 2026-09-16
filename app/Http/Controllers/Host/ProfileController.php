<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Host self-service profile.
 *
 * Until this existed, registration was the ONLY write path for a host's
 * contact details - a host who typed their phone number wrong at signup had
 * no way to correct it, and since that number is what the public Call and
 * WhatsApp buttons dial, every enquiry on their listings went nowhere.
 */
class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('host.profile', [
            'user' => request()->user(),
        ]);
    }

    public function update(HostProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->fill([
            'name'  => $validated['full_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            // Coalesced to null rather than left as '' so cleanWhatsappNumber()
            // falls back to phone_number - an empty string is truthy enough to
            // reach preg_replace and would yield a wa.me link to nowhere.
            'whatsapp_number' => $validated['whatsapp_number'] ?: null,
            'host_address' => $validated['host_address'] ?: null,
            'host_city'    => $validated['host_city'] ?: null,
            'host_state'   => $validated['host_state'] ?: null,
            'host_pincode' => $validated['host_pincode'] ?: null,
        ]);

        $user->save();

        return redirect()
            ->route('host.profile.edit')
            ->with('status', 'Your profile has been updated.');
    }
}
