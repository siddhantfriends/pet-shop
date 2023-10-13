<?php

namespace App\Http\Resources\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Category
 */
class CategoryShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<string, string|array<string, string|object|null>>
     */
    public function toArray(Request $request): array
    {
        return JsonResponse::response([
            'uuid' => $this->uuid,
            'title' => $this->title,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }
}
