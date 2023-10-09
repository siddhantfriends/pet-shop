<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class FailedValidation extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        // disable logging for failed validation
    }

    /**
     * Render the exception as a JSON response.
     */
    public function render(): JsonResponse
    {
        return JsonResponse::error($this->getMessage(), $this->getPrevious()->validator->errors(), $this->getCode());
    }
}
