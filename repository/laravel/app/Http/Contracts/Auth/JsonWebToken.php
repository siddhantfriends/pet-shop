<?php

namespace App\Http\Contracts\Auth;

use App\Models\User;

interface JsonWebToken
{
    public function issue(User $user, ?string $issuedBy = null, ?string $expiresAfter = null): string;
    public function parse(string $token): bool;
    public function validate(string $token): bool;
    public function uuid(string $token): string;
}
