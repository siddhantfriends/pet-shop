<?php

namespace App\Http\Service;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Contracts\ApiResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\CategoryIndexRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService extends ApiResourceService implements ApiResource
{
    public function store(CategoryStoreRequest|Request $request): Category
    {
        return Category::create($request->all());
    }

    public function update(CategoryUpdateRequest|Request $request, Category|Model $model): void
    {
        $category = Category::find($model->id);
        $category->update($request->all());
    }

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
