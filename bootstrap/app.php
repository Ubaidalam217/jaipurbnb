<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Railway terminates TLS at its edge and forwards to the container
        // over plain HTTP, so without this Laravel ignores X-Forwarded-Proto,
        // treats every request as insecure, and asset()/@vite emit http://
        // URLs that browsers then block as mixed content on the https page.
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'host'  => \App\Http\Middleware\EnsureUserIsHost::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
