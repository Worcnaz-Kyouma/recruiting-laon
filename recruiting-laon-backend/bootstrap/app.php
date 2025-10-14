<?php

use App\Exceptions\AppError;
use App\Exceptions\UnexpectedErrors\UnexpectedError;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/unauthorized-user'); // TODO: Try to remove it
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $e, Request $request) {
            if($e instanceof AuthenticationException) {
                return response()->json(
                    ['message' => 'Usuário não autorizado. Você deve estar logado com um usuário para usar esta rota. Procure as rotas createUser/login.']
                    , 401
                );
            }

            $error = $e instanceof AppError
                ? $e
                : new UnexpectedError($e->getMessage().$e->getTraceAsString()); // Default Error

            return $error->getHttpResponse();
        });
    })->create();
