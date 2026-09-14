<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Host signup validation.
 *
 * NOTE: 'role' is deliberately absent. It is not in User::$fillable and
 * must never be accepted from request input - the users table defaults
 * it to 'host'. Accepting it here would let anyone register as an admin.
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'full_name'    => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],

            // Optional: a host can complete their profile later from the
            // dashboard, so signup must not block on these.
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
            'full_name'    => 'full name',
            'phone_number' => 'phone number',
            'host_address' => 'address',
            'host_city'    => 'city',
            'host_state'   => 'state',
            'host_pincode' => 'pincode',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'phone_number.unique' => 'An account already exists with this phone number.',
            'email.unique'        => 'An account already exists with this email address.',
        ];
    }
}
