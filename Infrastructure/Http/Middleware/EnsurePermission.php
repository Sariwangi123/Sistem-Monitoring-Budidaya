<?php

namespace Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shared\Http\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

final class EnsurePermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasPermission($permission)) {
            return ApiResponse::error('This action is unauthorized.', [], 403);
        }

        return $next($request);
    }
}
