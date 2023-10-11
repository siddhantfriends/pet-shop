<?php

namespace App\Http\Controllers\User;

use JetBrains\PhpStorm\Pure;
use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginStoreResource;
use App\Http\Resources\LoginDestroyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/user/login",
     *     tags={"User"},
     *     summary="Login an User account",
     *     description="Test Description",
     *     operationId="user-login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
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
     *                 required={"email", "password"}
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
    public function store(UserService $userService): JsonResource
    {
        return new LoginStoreResource($userService->issueLoginToken());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/logout",
     *     tags={"User"},
     *     summary="Logout an User account",
     *     description="Test Description",
     *     operationId="user-logout",
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
     * Remove the specified resource from storage.
     */
    #[Pure]
    public function destroy(): JsonResource
    {
        return new LoginDestroyResource([]);
    }
}
