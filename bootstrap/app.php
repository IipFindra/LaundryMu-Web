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

        // ✅ TRUST PROXIES - WAJIB untuk ngrok/HTTPS
        $middleware->trustProxies(at: '*')
            ->trustHosts(at: ['*']);

        // ✅ CORS - Agar API bisa diakses dari Flutter/Browser lain
        $middleware->append(HandleCors::class);

        // ✅ Stateful domains untuk Sanctum (mendukung web + API hybrid)
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Biarkan default Laravel handle exception
    })->create();
