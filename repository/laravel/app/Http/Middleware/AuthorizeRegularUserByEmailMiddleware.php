<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions\FailedValidation;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeRegularUserByEmailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::whereEmail($request->get('email'))->first();

        if ($user->isAdmin()) {
            throw new FailedValidation('Invalid email', Response::HTTP_NOT_FOUND, null);
        }

        return $next($request);
    }
}
