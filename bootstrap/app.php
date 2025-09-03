<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
<<<<<<< HEAD
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\CheckAdmin;


=======
>>>>>>> c9dcbb0 (Push dự án Laravel lên GitHub)

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
<<<<<<< HEAD

    $middleware->alias([
        'auth' => Authenticate::class,
        'admin' => CheckAdmin::class,
         'check.status' => \App\Http\Middleware\CheckUserStatus::class,
    ]);
=======
        //
>>>>>>> c9dcbb0 (Push dự án Laravel lên GitHub)
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
