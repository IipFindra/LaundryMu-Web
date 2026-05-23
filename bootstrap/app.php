<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ 1. Trust semua proxy (biar Laravel percaya HTTPS dari ngrok)
        $middleware->trustProxies(at: '*')
            ->trustHosts(at: ['*']);

        // ✅ 2. Aktifkan CORS untuk API & Browser
        $middleware->append(HandleCors::class);

        // ✅ 3. Stateful API untuk Sanctum & Cookie Session
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Biarkan Laravel handle error default
    })->create();
