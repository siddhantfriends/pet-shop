<?php

namespace App\Http\Contracts;

use App\Models\Category;
use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryApiResource
{
    public function store(CategoryStoreRequest $request): Category;
    public function update(CategoryUpdateRequest $request, Category $model): void;
    public function destroy(Category $model): void;
    public function filter(CategoryIndexRequest $request): LengthAwarePaginator;
}
