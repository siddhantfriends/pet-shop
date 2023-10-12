<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Contracts\Auth\JsonWebToken;
use App\Http\Service\Auth\JsonWebTokenManager;
use App\Models\User;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            $rule = Password::min(4);

            return $this->app->isProduction()
                ? $rule->mixedCase()->uncompromised()
                : $rule;
        });

        $this->registerJsonWebToken();
        $this->registerAuthorizationGates();
    }

    public function registerJsonWebToken(): void {
        $this->app->singleton(JsonWebToken::class, fn () => new JsonWebTokenManager());
        $this->app->singleton('JsonWebToken', fn () => new JsonWebTokenManager());
    }

    public function registerAuthorizationGates(): void
    {
        Gate::define('user-access', function (User $user) {
            return $user->isNotAdmin();
        });

        Gate::define('admin-access', function (User $user) {
            return match($user->isAdmin()) {
                true => $user->isAdmin(),
                default => throw new UnauthorizedHttpException('Unauthorized: Not enough privileges'),
            };
        });
    }
}
