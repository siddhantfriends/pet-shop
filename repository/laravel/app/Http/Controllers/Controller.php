<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *     title="Pet Shop API - Swagger Documentation",
 *     description="Solution to the Pet Shop Challenge",
 *     contact="SiddhantBaviskar@outlook.com",
 *     version="1.0.0"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
