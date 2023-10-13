<?php

namespace App\Http\Requests\OrderStatus;

use Illuminate\Http\Response;
use App\Exceptions\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class OrderStatusUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws FailedValidation
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new FailedValidation(
            'Order status not found',
            Response::HTTP_NOT_FOUND,
            new ValidationException($validator)
        );
    }
}
