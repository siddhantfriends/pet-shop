<?php

namespace App\Http\Middleware;

use App\Events\TokenLastUsed;
use Auth;
use Carbon\Carbon;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Facades\JsonWebToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;

class JsonWebTokenAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if ($token && $this->hasValidToken($token)) {
            $user = $this->fetchUserFromDatabase($token);
            Auth::setUser($user);

            return $next($request);
        }

        throw new UnauthorizedException();
    }

    public function hasValidToken(string $token): bool
    {
        return JsonWebToken::parse($token) && JsonWebToken::validate($token);
    }

    public function fetchUserFromDatabase(string $token): User
    {
        $uuid = JsonWebToken::uuid($token);
        $user = User::whereUuid($uuid)->firstOrFail();

        TokenLastUsed::dispatch($uuid, Carbon::now());

        return $user;
    }
}
