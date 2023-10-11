<?php

namespace App\Http\Controllers\Admin;

use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginStoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserService $userService): JsonResource
    {
        return new LoginStoreResource($userService->issueLoginToken());
    }
}
