<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
<<<<<<< HEAD

=======
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\CheckAdmin;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

<<<<<<< HEAD

=======
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
    $middleware->alias([
        'auth' => Authenticate::class,
        'admin' => CheckAdmin::class,
         'check.status' => \App\Http\Middleware\CheckUserStatus::class,
    ]);
<<<<<<< HEAD

    })
    ->withExceptions(function (Exceptions $exceptions) {
=======
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
    })->create();
