<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return JsonResponse::response([
            'token' => $this->resource,
        ]);
    }
}
