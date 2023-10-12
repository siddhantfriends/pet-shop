<?php

namespace App\Http\Service;

use Carbon\Carbon;
use App\Models\User;
use App\Events\LoggedIn;
use App\Facades\JsonWebToken;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Admin\StoreAdminRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\UserListingIndexRequest;

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
     * The method edits a user
     * @throws \Throwable
     */
    public function editUser(UserEditRequest $request, User $user): void
    {
        $user->updateOrFail(
            $request->safe()->only([
                'first_name', 'last_name', 'email', 'password',
                'avatar', 'address', 'phone_number', 'is_marketing',
            ])
        );
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
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

    public function filter(UserListingIndexRequest $request): LengthAwarePaginator
    {
        return User::users()
            ->whereLikeFilters([
                'first_name' => $request->get('first_name'),
                'email' => $request->get('email'),
                'phone_number' => $request->get('phone'),
                'address' => $request->get('address'),
                'created_at' => $request->get('created_at'),
            ])->whereFilters([
                'is_marketing' => $request->get('marketing'),
            ])->sortBy(
                $request->get('sortBy', 'id'),
                match ($request->get('desc', true)) {
                    true => 'desc', default => 'asc'
                },
            )->paginate(perPage: $request->get('limit', 10));
    }
}
