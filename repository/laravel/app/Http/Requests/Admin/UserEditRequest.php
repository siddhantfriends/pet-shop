<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'avatar' => ['nullable', 'uuid', 'exists:files,uuid'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'is_marketing' => ['boolean'],
        ];
    }
}
