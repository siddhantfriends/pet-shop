<?php

namespace App\Http\Controllers;

use App\Http\Service\PasswordResetService;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\ResetPasswordResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ResetPasswordController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/user/reset-password-token",
     *     tags={"User"},
     *     summary="Reset a user password with the a token",
     *     description="Test Description",
     *     operationId="user-reset-pass-token",
     *     @OA\Parameter(
     *         name="token",
     *         in="query",
     *         description="User reset token",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="User password",
     *         required=true,
     *         @OA\Schema(type="string")
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
     * Handle the incoming request.
     */
    public function __invoke(ResetPasswordRequest $request, PasswordResetService $service): JsonResource
    {
        $service->updatePassword($request);

        return new ResetPasswordResource('Password has been successfully updated');
    }
}
