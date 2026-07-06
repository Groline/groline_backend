<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Laravel\Sanctum\PersonalAccessToken;

class SometimesAuth
{
    public function handle(Request $request, Closure $next)
    {
        $bearer = $request->bearerToken();

        if (! $bearer) {
            return $next($request);
        }

        $token = PersonalAccessToken::findToken($bearer);

        if (! $token || ! $this->isValid($token)) {
            throw new AuthenticationException('Unauthenticated.');
        }

        Auth::guard('sanctum')->setUser($token->tokenable);
        Auth::shouldUse('sanctum');

        $token->forceFill(['last_used_at' => now()])->save();

        return $next($request);
    }

    protected function isValid(PersonalAccessToken $token): bool
    {
        $expiration = config('sanctum.expiration');

        return ! $expiration || $token->created_at->gt(now()->subMinutes($expiration));
    }
    
}