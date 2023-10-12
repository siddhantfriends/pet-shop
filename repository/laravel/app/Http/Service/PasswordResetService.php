<?php

namespace App\Http\Service;

use App\Models\PasswordReset;
use App\Http\Requests\ForgotPasswordRequest;

class PasswordResetService
{
    public function execute(ForgotPasswordRequest $request): PasswordReset
    {
        return PasswordReset::create([
            'email' => $request->email,
        ]);
    }
}
