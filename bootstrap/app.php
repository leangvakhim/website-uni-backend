<?php

// use Illuminate\Foundation\Application;
// use Illuminate\Foundation\Configuration\Exceptions;
// use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Support\Facades\Route;


// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__.'/../routes/web.php',
//         commands: __DIR__.'/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         $middleware->alias([
//             'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
//             'auth:api' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
//         ]);

//         $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
//     })
//     // ->withMiddleware(function (Middleware $middleware) {
//     //     $middleware->prepend(\Illuminate\Http\Middleware\HandleCors::class);
//     // })
//     ->withExceptions(function (Exceptions $exceptions) {
//         //
//     })->create();

// $app->loadConfigurationFiles(['cors']);

// return $app;

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
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'auth:api' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        ]);

        $middleware->prepend(\Illuminate\Http\Middleware\HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->loadConfigurationFiles(['cors']);

return $app;