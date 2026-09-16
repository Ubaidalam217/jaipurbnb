<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Host self-service profile update.
 *
 * Mirrors RegisterRequest, with two differences that matter:
 *
 *  - The unique rules must IGNORE the current user, or a host who saves the
 *    form without touching their email or phone fails validation against
 *    their own row.
 *  - 'password' and 'role' are absent on purpose. Password changes go through
 *    the existing reset flow, and role is not fillable - accepting it here
 *    would let any host promote themselves to admin.
 */
class HostProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // The route is already behind the auth + host middleware; this is the
        // second gate, so a future route change cannot silently open it up.
        return $this->user() !== null;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'full_name' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($userId)],
            'phone_number' => [
                'required', 'string', 'max:20',
                Rule::unique('users', 'phone_number')->ignore($userId),
            ],

            // Not unique - see the migration note: a family business may share
            // one WhatsApp line across two host accounts.
            'whatsapp_number' => ['nullable', 'string', 'max:20'],

            'host_address' => ['nullable', 'string', 'max:2000'],
            'host_city'    => ['nullable', 'string', 'max:100'],
            'host_state'   => ['nullable', 'string', 'max:100'],
            'host_pincode' => ['nullable', 'string', 'max:10'],
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'full_name'       => 'full name',
            'phone_number'    => 'phone number',
            'whatsapp_number' => 'WhatsApp number',
            'host_address'    => 'address',
            'host_city'       => 'city',
            'host_state'      => 'state',
            'host_pincode'    => 'pincode',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'phone_number.unique' => 'Another account already uses this phone number.',
            'email.unique'        => 'Another account already uses this email address.',
        ];
    }
}
