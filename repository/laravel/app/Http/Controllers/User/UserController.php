<?php

namespace App\Http\Controllers\User;

use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Contracts\Auth\JsonWebToken;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\StoreUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/user/create",
     *     tags={"User"},
     *     summary="Create a User account",
     *     description="Test Description",
     *     operationId="user-create",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     description="User firstname",
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="User lastname",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="User email",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="User password",
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     description="User password",
     *                 ),
     *                @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     description="Avatar image UUID",
     *                 ),
     *               @OA\Property(
     *                     property="address",
     *                     type="string",
     *                     description="User main address",
     *                 ),
     *               @OA\Property(
     *                     property="phone_number",
     *                     type="string",
     *                     description="User main phone number",
     *                 ),
     *               @OA\Property(
     *                     property="is_marketing",
     *                     description="User marketing preferences",
     *                     type="string",
     *                     enum={"0", "1"}
     *                 ),
     *                 required={
     *                      "first_name", "last_name",
     *                      "email", "password", "password_confirmation",
     *                      "address","phone_number"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal server error"
     *     )
     * )
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserService $service, JsonWebToken $jsonWebToken): JsonResource
    {
        $user = $service->createUser($request);

        return new StoreUserResource($user->fresh(), $jsonWebToken->issue($user));
    }
}
