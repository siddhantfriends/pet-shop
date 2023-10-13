<?php

namespace App\Http\Service;

use App\Models\Product;
use App\Http\Contracts\ProductApiResource;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductService implements ProductApiResource
{
    public function store(ProductStoreRequest $request): Product
    {
        return Product::create($request->only([
            'category_uuid', 'title', 'price', 'description', 'metadata',
        ]));
    }

    public function update(ProductUpdateRequest $request, Product $product): void
    {
        $product->update($request->only([
            'category_uuid', 'title', 'price', 'description', 'metadata',
        ]));
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }

    public function filter(ProductIndexRequest $request): LengthAwarePaginator
    {
        return Product::query()
            ->sortBy(
                $request->get('sortBy', 'id'),
                match ($request->get('desc', true)) {
                    true => 'desc', default => 'asc'
                },
            )->paginate(perPage: $request->get('limit', 10));
    }
}
