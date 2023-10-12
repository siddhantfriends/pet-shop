<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserListingIndexCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var class-string $collects
     */
    public $collects = UserListingIndexResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     * @return array<int|string, object|null>
     */
    public function toArray(Request $request): array
    {
        return ['resource' => $this->resource];
    }
}
