<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class FileNotFound extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(): JsonResponse
    {
        return JsonResponse::error($this->getMessage(), status: $this->getCode());
    }
}
