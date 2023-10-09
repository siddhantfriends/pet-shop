<?php

namespace App\Http\Contracts\Auth;

interface JsonWebToken
{
    public function issue(): void;
    public function parse(): void;
    public function validate(): void;
}
