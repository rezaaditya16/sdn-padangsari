<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'parent.auth' => \App\Http\Middleware\ParentAuth::class,
            'admin.role' => \App\Http\Middleware\AdminRoleMiddleware::class,
            'redirect.role' => \App\Http\Middleware\RedirectBasedOnRole::class,
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);
        
        // Configure authentication redirects
        $middleware->redirectGuestsTo('/admin/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
