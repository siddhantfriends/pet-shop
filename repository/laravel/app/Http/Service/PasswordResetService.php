<?php

namespace App\Http\Service;

use App\Models\User;
use App\Models\PasswordReset;
use App\Jobs\ResetPasswordTokenCleanupJob;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;

class PasswordResetService
{
    public function execute(ForgotPasswordRequest $request): PasswordReset
    {
        return PasswordReset::create([
            'email' => $request->email,
        ]);
    }

    public function updatePassword(ResetPasswordRequest $request): void
    {
        $user = User::whereEmail($request->email)->firstOrFail();
        $user->update(['password' => $request->password]);

        ResetPasswordTokenCleanupJob::dispatchAfterResponse($request->token);
    }
}
