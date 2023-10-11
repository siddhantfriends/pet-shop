<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class Unauthorized extends Exception
{
    /**
     * Render the exception as a JSON response.
     */
    public function render(): JsonResponse
    {
        return JsonResponse::error($this->getMessage(), status: $this->getCode());
    }
}
