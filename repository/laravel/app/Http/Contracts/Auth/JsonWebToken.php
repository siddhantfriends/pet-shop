<?php

namespace App\Http\Contracts\Auth;

use App\Models\User;

interface JsonWebToken
{
    public function issue(User $user): string;
    public function parse(): void;
    public function validate(): void;
}
