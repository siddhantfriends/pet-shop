<?php

namespace App\Http\Contracts\Auth;

use App\Models\User;

interface JsonWebToken
{
    public function issue(User $user): string;
    public function parse(string $token): bool;
    public function validate(): void;
}
