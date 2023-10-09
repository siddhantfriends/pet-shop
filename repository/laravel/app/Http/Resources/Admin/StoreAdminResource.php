<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User;
 */
class StoreAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, object|null>
     */
    public function toArray(Request $request): array
    {
        return JsonResponse::response([
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
        ]);
    }
}
