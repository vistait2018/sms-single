<?php

use App\Http\Middleware\CheckInternet;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\EnsureSchoolAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'super_admin' => EnsureSuperAdmin::class,
             'check_internet' => CheckInternet::class,
             'school_admin'=> EnsureSchoolAdmin::class
        ]);
       
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
