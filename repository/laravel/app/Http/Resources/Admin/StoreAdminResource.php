<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User;
 */
class StoreAdminResource extends JsonResource
{
    protected string $token;

    public function __construct(User $resource, string $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, object|null>
     */
    public function toArray(Request $request): array
    {
        return JsonResponse::response([
            'uuid' => $this->uuid,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'avatar' => $request->avatar,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'token' => $this->token,
        ]);
    }
}
