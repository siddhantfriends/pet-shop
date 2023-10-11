<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ValidationException $e): void {
            throw new FailedValidation('Failed Validation', Response::HTTP_UNPROCESSABLE_ENTITY, $e);
        });

        $this->renderable(function (NotFoundHttpException $e): void {
            match(get_class($e->getPrevious())) {
                ModelNotFoundException::class => throw new FileNotFound('File not found', Response::HTTP_NOT_FOUND, $e),
                default => throw new RouteNotFound('Invalid URI', Response::HTTP_NOT_FOUND, $e),
            };
        });

        $this->renderable(function (UnauthorizedException $e): void {
            throw new Unauthorized('Unauthorized', Response::HTTP_UNAUTHORIZED, $e);
        });

        $this->renderable(function (Exception $e): void {
            throw new Unhandled('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR, $e);
        });
    }
}
