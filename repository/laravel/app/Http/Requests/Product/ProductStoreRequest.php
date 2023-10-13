<?php

namespace App\Http\Requests\Product;

use Illuminate\Http\Response;
use App\Exceptions\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ProductStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'category_uuid' => ['required', 'uuid', 'exists:categories,uuid'],
            'title' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'metadata' => ['required', 'json'],
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
            'Failed to create new product',
            Response::HTTP_NOT_FOUND,
            new ValidationException($validator)
        );
    }
}
