<?php

namespace App\Http\Requests;

use App\Exceptions\FailedValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class CategoryUpdateRequest extends FormRequest
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
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @throws FailedValidation
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new FailedValidation('Category not found', Response::HTTP_NOT_FOUND, null);
    }
}
