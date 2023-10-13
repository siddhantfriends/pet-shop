<?php

namespace App\Http\Service;

use App\Models\Category;
use App\Http\Contracts\ApiResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

abstract class ApiResourceService implements ApiResource
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param CategoryStoreRequest $request
     */
    public function store($request): Category|Model
    {
        return Model::create($request->all());
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param CategoryUpdateRequest $request
     * @param Category|Model $model
     */
    public function update($request, $model): void
    {
        $model->update($request->all());
    }

    /**
     */
    public function destroy(Category|Model $model): void
    {
        $model->delete();
    }
}
