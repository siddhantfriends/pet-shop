<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use App\Exceptions\FailedValidation;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'exists:password_resets,token'],
            'email' => ['required', 'email', 'exists:password_resets,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @throws FailedValidation
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new FailedValidation('Invalid or expired token', Response::HTTP_UNPROCESSABLE_ENTITY, null);
    }
}
