<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RouteNotFound extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('Route Not Found Exception', [
            'file' => $this->getPrevious()->getFile(),
            'line' => $this->getPrevious()->getLine(),
            'message' => $this->getPrevious()->getMessage(),
            'trace' => $this->getPrevious()->getTrace(),
        ]);
    }

    /**
     * Render the exception as a JSON response.
     */
    public function render(): JsonResponse
    {
        return JsonResponse::error($this->getMessage(), status: $this->getCode());
    }
}
