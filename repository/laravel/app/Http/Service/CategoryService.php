<?php

namespace App\Http\Service;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Contracts\CategoryApiResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;

class CategoryService extends CategoryApiResourceService implements CategoryApiResource
{
    public function store(CategoryStoreRequest|Request $request): Category
    {
        return Category::create($request->all());
    }

    /**
     * @param Category $model
     */
    public function update(CategoryUpdateRequest|Request $request, Category|Model $model): void
    {
        $category = Category::find($model->id);
        $category->update($request->all());
    }

    /**
     * @param Category $model
     */
    public function destroy(Category|Model $model): void
    {
        $category = Category::find($model->id);
        $category->delete();
    }

    public function filter(CategoryIndexRequest|Request $request): LengthAwarePaginator
    {
        return Category::query()
            ->sortBy(
                $request->get('sortBy', 'id'),
                match ($request->get('desc', true)) {
                    true => 'desc', default => 'asc'
                },
            )->paginate(perPage: $request->get('limit', 10));
    }
}
