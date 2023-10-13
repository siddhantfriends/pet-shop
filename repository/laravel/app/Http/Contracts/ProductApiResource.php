<?php

namespace App\Http\Contracts;

use App\Models\Product;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductApiResource
{
    public function store(ProductStoreRequest $request): Product;
    public function update(ProductUpdateRequest $request, Product $model): void;
    public function destroy(Product $model): void;
    public function filter(ProductIndexRequest $request): LengthAwarePaginator;
}
