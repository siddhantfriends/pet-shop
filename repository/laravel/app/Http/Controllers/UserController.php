<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\StoreUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResource
    {
        $validated = $request->safe()->merge(
            [
                'is_admin' => false,
            ]
        );

        $user = User::create($validated->toArray());

        return new StoreUserResource($user->fresh());
    }
}
