<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class JsonWebToken extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'JsonWebToken';
    }
}
