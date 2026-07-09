<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Infrastructure\Http\Middleware\ApiResponseHeaders;
use Infrastructure\Http\Middleware\EnsurePermission;
use Shared\Http\ApiResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(append: [
            ApiResponseHeaders::class,
        ]);
        $middleware->alias([
            'permission' => EnsurePermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $exception) {
            return ApiResponse::error('Resource not found.', [], 404);
        });
    })
    ->create();
