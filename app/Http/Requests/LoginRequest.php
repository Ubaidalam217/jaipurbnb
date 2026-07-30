<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Host + admin login validation. Which dashboard the user lands on is
 * decided from users.role after a successful attempt, not here.
 *
 * NOTE on 'remember': the checkbox in the view MUST send value="1".
 * An unvalued HTML checkbox submits the string "on", which fails the
 * 'boolean' rule.
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }
}
