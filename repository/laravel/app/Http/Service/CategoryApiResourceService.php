<?php

namespace App\Http\Service;

use App\Models\Category;
use App\Http\Contracts\CategoryApiResource;
use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class CategoryApiResourceService implements CategoryApiResource
{
    public function store(CategoryStoreRequest $request): Category
    {
        return Category::create($request->all());
    }

    public function update(CategoryUpdateRequest $request, Category $model): void
    {
        $model->update($request->all());
    }

    public function destroy(Category $model): void
    {
        $model->delete();
    }

    public function filter(CategoryIndexRequest $request): LengthAwarePaginator
    {
        return Category::query()
            ->paginate(perPage: $request->get('limit', 10));
    }
}
