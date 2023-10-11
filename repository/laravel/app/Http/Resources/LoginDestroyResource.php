<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginDestroyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return JsonResponse::response($this->resource);
    }
}