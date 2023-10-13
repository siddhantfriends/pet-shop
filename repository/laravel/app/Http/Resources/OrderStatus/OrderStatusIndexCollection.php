<?php

namespace App\Http\Resources\OrderStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderStatusIndexCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var class-string $collects
     */
    public $collects = OrderStatusIndexResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<int|string, string|array<string, string>|null>
     */
    public function toArray(Request $request): array
    {
        return ['resource' => $this->resource];
    }
}
