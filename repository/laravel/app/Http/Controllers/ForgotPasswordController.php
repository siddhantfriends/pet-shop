<?php

namespace App\Http\Controllers;

use App\Http\Service\PasswordResetService;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Resources\ForgotPasswordResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ForgotPasswordController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/user/forgot-password",
     *     tags={"User"},
     *     summary="Creates a token to reset a user password",
     *     description="Test Description",
     *     operationId="user-forgot-pass",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User email",
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
    public function __invoke(ForgotPasswordRequest $request, PasswordResetService $passwordResetService): JsonResource
    {
        $reset = $passwordResetService->execute($request);

        return new ForgotPasswordResource($reset->fresh());
    }
}
