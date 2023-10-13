<?php

namespace App\Exceptions;

use Exception;
use App\Models\File;
use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderStatus;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        $this->registerFailedValidation();
        $this->registerNotFoundExceptions();
        $this->registerFailedAuthentication();
        $this->registerUnauthorized();

        $this->renderable(function (ThrottleRequestsException $e): void {
            throw new Throttle('Too Many Attempts', Response::HTTP_UNPROCESSABLE_ENTITY, $e);
        });

        $this->renderable(function (Exception $e): void {
            throw new Unhandled('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR, $e);
        });
    }

    private function registerFailedValidation(): void
    {
        $this->renderable(function (ValidationException $e): void {
            throw new FailedValidation('Failed Validation', Response::HTTP_UNPROCESSABLE_ENTITY, $e);
        });
    }

    private function registerNotFoundExceptions(): void
    {
        $this->renderable(
            fn (NotFoundHttpException $e) => match (get_class($e->getPrevious())) {
                ModelNotFoundException::class => match ($e->getPrevious()->getModel()) {
                    File::class => throw new FileNotFound('File not found', Response::HTTP_NOT_FOUND, $e),
                    User::class => throw new UserNotFound('Unauthorized', Response::HTTP_UNAUTHORIZED, $e),
                    Product::class => throw new ProductNotFound('Product not found', Response::HTTP_NOT_FOUND, $e),
                    Category::class => throw new CategoryNotFound(
                        'Category not found',
                        Response::HTTP_NOT_FOUND,
                        $e
                    ), OrderStatus::class => throw new OrderStatusNotFound(
                        'Order status not found',
                        Response::HTTP_NOT_FOUND,
                        $e
                    ), Payment::class => throw new PaymentNotFound('Payment not found', Response::HTTP_NOT_FOUND, $e),
                    default => throw new Unauthorized('Unauthorized', Response::HTTP_UNAUTHORIZED, $e),
                },
                default => throw new RouteNotFound('Invalid URI', Response::HTTP_NOT_FOUND, $e),
            },
        );
    }

    private function registerFailedAuthentication(): void
    {
        $this->renderable(function (AccessDeniedHttpException $e): void {
            throw new FailedAuthentication('Failed to authenticate user', Response::HTTP_UNPROCESSABLE_ENTITY, $e);
        });
    }

    private function registerUnauthorized(): void
    {
        $this->renderable(function (UnauthorizedHttpException $e): void {
            throw new Unauthorized('Unauthorized: Not enough privileges', Response::HTTP_UNPROCESSABLE_ENTITY, $e);
        });

        $this->renderable(function (UnauthorizedException $e): void {
            throw new Unauthorized('Unauthorized', Response::HTTP_UNAUTHORIZED, $e);
        });
    }
}
