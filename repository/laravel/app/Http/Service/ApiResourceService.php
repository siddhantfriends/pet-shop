<?php

namespace App\Http\Service;

use App\Models\Category;
use App\Models\BaseModel;
use Illuminate\Http\Request;
use App\Http\Contracts\ApiResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class ApiResourceService implements ApiResource
{
    public function store(CategoryStoreRequest|Request $request): Category|Model
    {
        return Model::create($request->all());
    }

    public function update(CategoryUpdateRequest|Request $request, Category|Model $model): void
    {
        $model->update($request->all());
    }

    public function destroy(Category|Model $model): void
    {
        $model->delete();
    }

    public function filter(CategoryIndexRequest|Request $request): LengthAwarePaginator
    {
        return BaseModel::query()
            ->paginate(perPage: $request->get('limit', 10));
    }
}
