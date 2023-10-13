<?php

namespace App\Http\Service;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Contracts\ApiResource;
use App\Http\Requests\CategoryIndexRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService extends ApiResourceService implements ApiResource
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param CategoryStoreRequest $request
     */
    public function store($request): Category
    {
        return Category::create($request->all());
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param CategoryStoreRequest|CategoryUpdateRequest $request
     * @param Category $model
     */
    public function update($request, $model): void
    {
        $category = Category::find($model->id);
        $category->update($request->all());
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param Category $model
     */
    public function destroy($model): void
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
