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
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'full_name'    => 'full name',
            'phone_number' => 'phone number',
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
