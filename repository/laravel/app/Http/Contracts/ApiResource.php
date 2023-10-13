<?php

namespace App\Http\Contracts;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Category\CategoryIndexRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ApiResource
{
    public function store(CategoryStoreRequest|Request $request): Category|Model;
    public function update(CategoryUpdateRequest|Request $request, Category|Model $model): void;
    public function destroy(Category|Model $model): void;
    public function filter(CategoryIndexRequest|Request $request): LengthAwarePaginator;
}
