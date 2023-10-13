<?php

namespace App\Http\Service;

use App\Models\Category;
use App\Http\Contracts\ApiResource;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

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
}
