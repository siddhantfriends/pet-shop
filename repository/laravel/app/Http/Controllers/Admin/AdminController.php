<?php

namespace App\Http\Controllers\Admin;

use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Resources\Admin\StoreAdminResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request, UserService $service): JsonResource
    {
        $user = $service->createUser($request);

        return new StoreAdminResource($user->fresh());
    }
}
