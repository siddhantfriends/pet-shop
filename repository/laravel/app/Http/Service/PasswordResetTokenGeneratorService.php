<?php

namespace App\Http\Service;

use App\Models\PasswordReset;
use Illuminate\Database\Eloquent\Model;

class PasswordResetTokenGeneratorService
{
    public const LENGTH = 128 / 2;

    public function handle(PasswordReset $reset): void
    {
        $reset::creating(function (Model $reset): void {
            $reset->setAttribute('token', bin2hex(openssl_random_pseudo_bytes(self::LENGTH)));
        });
    }
}
