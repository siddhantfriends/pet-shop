<?php

namespace App\Http\Service;

use App\Models\PasswordReset;

class PasswordResetTokenGeneratorService
{
    public const LENGTH = 128 / 2;

    public function handle(PasswordReset $reset): void
    {
        $reset::creating(function (PasswordReset $reset): void {
            $this->flushPreviousEntries();
            $reset->setAttribute('token', bin2hex(openssl_random_pseudo_bytes(self::LENGTH)));
        });
    }

    private function flushPreviousEntries(): void
    {
        PasswordReset::whereEmail(request()->email)->delete();
    }
}
