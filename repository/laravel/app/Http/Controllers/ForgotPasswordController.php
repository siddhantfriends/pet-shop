<?php

namespace App\Http\Controllers;

use App\Http\Service\PasswordResetService;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Resources\ForgotPasswordResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ForgotPasswordRequest $request, PasswordResetService $passwordResetService): JsonResource
    {
        $reset = $passwordResetService->execute($request);

        return new ForgotPasswordResource($reset->fresh());
    }
}
