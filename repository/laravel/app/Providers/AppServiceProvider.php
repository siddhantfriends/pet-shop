<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        JsonResponse::macro('error', function(string $message, array|MessageBag $errors = [], int $status = Response::HTTP_NOT_FOUND): JsonResponse {
            return response()->json([
                'success' => 0,
                'data' => [],
                'error' => $message,
                'errors' => $errors,
                'trace' => [],
            ], $status);
        });
    }
}
