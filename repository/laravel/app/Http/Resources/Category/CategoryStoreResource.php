<?php

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Category
 */
class CategoryStoreResource extends JsonResource
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
            'uuid' => $this->uuid,
        ]);
    }
}
