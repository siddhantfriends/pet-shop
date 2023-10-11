<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\LoginDestroyResource;
use App\Http\Service\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginStoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/admin/login",
     *     tags={"Admin"},
     *     summary="Login an Admin account",
     *     description="Test Description",
     *     operationId="admin-login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Admin email",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="Admin password",
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
     *     path="/api/v1/admin/logout",
     *     tags={"Admin"},
     *     summary="Logout an Admin account",
     *     description="Test Description",
     *     operationId="admin-logout",
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
    public function destroy()
    {
        return new LoginDestroyResource([]);
    }
}
