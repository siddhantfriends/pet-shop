<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FailedValidation extends Exception
{
    public function __invoke(ValidationException $e): JsonResponse
    {
        return response()->json(
            [
                'success' => 0,
                'data' => [],
                'error' => $this->getMessage(),
                'errors' => $e->validator->errors(),
                'trace' => [],
            ],
            $this->getCode()
        );
    }
}
