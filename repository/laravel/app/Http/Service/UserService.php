<?php

namespace App\Http\Service;

use Carbon\Carbon;
use App\Models\User;
use App\Events\LoggedIn;
use App\Facades\JsonWebToken;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Admin\StoreAdminRequest;

/**
 * The service is responsible for storing users of user and admin type.
 */
class UserService
{
    /**
     * The method creates a user
     */
    public function createUser(StoreUserRequest|StoreAdminRequest $request): User
    {
        $validated = $request->safe()->merge(
            [
                'is_admin' => $this->isAdmin($request),
            ]
        );

        return User::create($validated->toArray());
    }

    /**
     * The method returns true for admin else false
     */
    public function isAdmin(StoreUserRequest|StoreAdminRequest $request): bool
    {
        return match ($request::class) {
            StoreAdminRequest::class => true,
            default => false,
        };
    }

    public function issueLoginToken(): string
    {
        $user = request()->user();
        $token = JsonWebToken::issue($user);

        LoggedIn::dispatch($user->id, JsonWebToken::storeToken($token), Carbon::now());

        return $token;
    }
}
