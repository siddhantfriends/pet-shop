<?php

namespace App\Facades;

use App\Http\Service\Auth\JWTService;
use Illuminate\Support\Facades\Facade;

class JsonWebToken extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return JWTService::class;
    }
}
