<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class Unhandled extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('Unhandled Exception', [
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'message' => $this->getMessage(),
            'trace' => $this->getTrace(),
        ]);
    }

    /**
     * Render the exception as an JSON response.
     */
    public function render(): JsonResponse
    {
        return JsonResponse::error($this->getMessage(), status: $this->getCode());
    }
}
