<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Service\CategoryService;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryStoreResource;
use App\Http\Resources\CategoryUpdateResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request, CategoryService $service): JsonResource
    {
        $category = $service->store($request);
        return new CategoryStoreResource($category->fresh());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category, CategoryService $service): JsonResource
    {
        $service->update($request, $category);
        return new CategoryUpdateResource($category->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        //
    }
}
