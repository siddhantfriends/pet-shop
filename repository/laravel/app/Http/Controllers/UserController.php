<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\StoreUserResource;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->safe()->merge([
            'is_admin' => false,
        ]);

        $user = User::create($validated->toArray());

        return new StoreUserResource($user->fresh());
    }
}
