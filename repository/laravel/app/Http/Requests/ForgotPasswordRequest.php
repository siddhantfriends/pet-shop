<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use App\Exceptions\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
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
        throw new FailedValidation('Invalid email', Response::HTTP_NOT_FOUND, null);
    }
}
