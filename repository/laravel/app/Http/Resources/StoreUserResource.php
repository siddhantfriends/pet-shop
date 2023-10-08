<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User;
 */
class StoreUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, array|object|string|numeric|null>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'is_marketing' => $this->is_marketing,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'token' => 'placeholder for token',
        ];
    }

    /**
     * Get any additional data that should be returned with the resource array.
     *
     * @return array<string, array|object|string|numeric|null>
     */
    public function with(Request $request): array
    {
        return [
            'success' => 1,
        ];
    }
}
