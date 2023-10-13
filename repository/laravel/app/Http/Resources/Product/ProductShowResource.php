<?php

namespace App\Http\Resources\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryShowResource;

/**
 * @mixin Product
 */
class ProductShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<string, string|object|null>
     */
    public function toArray(Request $request): array
    {
        $category = new CategoryShowResource($this->category);

        return JsonResponse::response([
            'category_uuid' => $this->category_uuid,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'metadata' => json_decode(json_encode($this->metadata)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'category' => [
                'uuid' => $category->resource->uuid,
                'title' => $category->resource->title,
                'slug' => $category->resource->slug,
                'created_at' => $category->resource->created_at,
                'updated_at' => $category->resource->updated_at,
            ],
            'brand' => null,
        ]);
    }
}
