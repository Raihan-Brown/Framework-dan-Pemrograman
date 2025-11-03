<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- INI YANG DITAMBAHKAN ---
        // Mendaftarkan semua alias middleware kamu
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            
            // INI YANG PALING PENTING BUAT ERROR KAMU:
            'RoleCheck' => \App\Http\Middleware\RoleCheck::class,
        ]);
        // --- BATAS PENAMBAHAN ---

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();