<?php

namespace App\Http\Requests;

use App\Http\Resources\FailedValidationResource;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'avatar' => ['nullable', 'string', 'exists:files,uuid'],
            'is_marketing' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'success' => 0,
            'data' => [],
            'error' => 'Failed Validation',
            'errors' => $validator->errors(),
            'trace' => [],
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
