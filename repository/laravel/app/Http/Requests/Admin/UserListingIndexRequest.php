<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserListingIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'numeric',
            'limit' => 'numeric',
            'sortBy' => 'string',
            'desc' => 'boolean',
            'first_name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'address' => 'string',
            'created_at' => 'date',
            'marketing' => ['string', 'in:0,1'],
        ];
    }
}
