<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Service\UserService;
use App\Http\Requests\LoginStoreRequest;
use App\Http\Resources\LoginStoreResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Auth\Access\AuthorizationException;

class LoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginStoreRequest $request, UserService $userService): JsonResource
    {
        Auth::attempt($request->validated());

        return match (Auth::user()) {
            null => throw new AuthorizationException(),
            default => new LoginStoreResource($userService->issueLoginToken()),
        };
    }
}
