<?php

namespace App\Http\Contracts;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

interface ApiResource
{
    /**
     */
    public function store(CategoryStoreRequest|Request $request): Category|Model;

    /**
     */
    public function update(CategoryUpdateRequest|Request $request, Category|Model $model): void;

    /**
     */
    public function destroy(Category|Model $model): void;
}
