<?php

use App\Http\Middleware\CheckInternet;
use App\Http\Middleware\EnsureClassTeacher;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\EnsureSchoolAdmin;
use App\Http\Middleware\EnsureSchoolAdminOrClassTeacher;
use App\Http\Middleware\EnsureTeacher;
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
             'school_admin'=> EnsureSchoolAdmin::class,
            'class_teacher'=> EnsureClassTeacher::class,
            'school_admin_or_teacher' => EnsureSchoolAdminOrClassTeacher::class,
            'teacher' => EnsureTeacher::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
