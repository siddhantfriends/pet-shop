<?php

namespace App\Http\Requests\Payment;

use Illuminate\Http\Response;
use App\Exceptions\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PaymentUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string'],
            'details' => ['required', 'json'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws FailedValidation
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new FailedValidation('Payment not found', Response::HTTP_NOT_FOUND, new ValidationException($validator));
    }
}
