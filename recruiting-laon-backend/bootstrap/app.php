<?php

use App\Exceptions\AppError;
use App\Exceptions\UnexpectedErrors\UnexpectedError;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $e, Request $request) {
            $error = $e instanceof AppError
                ? $e
                : new UnexpectedError($e->getMessage()); // Default Error

            return $error->getHttpResponse();
        });
    })->create();
