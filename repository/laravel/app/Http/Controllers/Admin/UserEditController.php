<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Resources\Admin\UserEditResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws \Throwable
     */
    public function __invoke(UserEditRequest $request, User $user, UserService $userService): JsonResource
    {
        $userService->editUser($request, $user);
        return new UserEditResource($user);
    }
}
