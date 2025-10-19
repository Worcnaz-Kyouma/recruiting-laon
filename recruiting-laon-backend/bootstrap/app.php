<?php

use App\Exceptions\AppError;
use App\Exceptions\UnexpectedErrors\UnexpectedError;
use App\Http\Middleware\SetSameSiteCookie;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        $middleware->api(append: [
            StartSession::class,
            // EnsureFrontendRequestsAreStateful::class
            SetSameSiteCookie::class
        ]);

        $middleware->redirectGuestsTo('/unauthorized-user');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $e, Request $request) {
            if($e instanceof AuthenticationException) {
                return response()->json(
                    ['error' => 'Usuário não autorizado. Você deve estar logado com um usuário para utilizar este recurso.']
                    , 401
                );
            }

            $error = $e instanceof AppError
                ? $e
                : new UnexpectedError($e->getMessage().$e->getTraceAsString()); // Default Error

            return $error->getHttpResponse();
        });
    })->create();
