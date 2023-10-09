<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FailedValidation extends Exception
{
    public ValidationException $ex;

    /**
     * FailedValidation constructor.
     */
    #[Pure] public function __construct(string $message, int $code, ValidationException $previous)
    {
        parent::__construct($message, $code, $previous);

        $this->ex = $previous;
    }

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
        return JsonResponse::error($this->getMessage(), $this->ex->validator->errors(), $this->getCode());
    }
}
