<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Service\CategoryService;
use App\Http\Requests\CategoryIndexRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryShowResource;
use App\Http\Resources\CategoryStoreResource;
use App\Http\Resources\CategoryUpdateResource;
use App\Http\Resources\CategoryDestroyResource;
use App\Http\Resources\CategoryIndexCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryIndexRequest $request, CategoryService $service): JsonResponse
    {
        $response = new CategoryIndexCollection($service->filter($request));

        return response()->json($response->resource);
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
    public function show(Category $category): JsonResource
    {
        return new CategoryShowResource($category);
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
    public function destroy(Category $category, CategoryService $service): JsonResource
    {
        $service->destroy($category);

        return new CategoryDestroyResource([]);
    }
}
