<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TVSerieController;
use Illuminate\Support\Facades\Route;

// TODO: IMPORTANT validate all the "use" imports and removed unused ones 
// TODO: Make cache!
Route::get('/', function () {
    return response()->json(['message' => 'Bem vindo a Laon-Catalog! Você deve estar logado com um usuário para usar a maioria dos recursos. Procure as rotas createUser/login.']);
});

Route::prefix("user")->group(function () {
    Route::post("", [\App\Http\Controllers\UserController::class, "createUser"]);
    Route::post("/login", [\App\Http\Controllers\UserController::class, "login"]);
    Route::post("/logout/{id}", [\App\Http\Controllers\UserController::class, "logout"])->middleware("auth:sanctum");
});

// TODO: Filter movies without poster and overview
Route::prefix("media")->group(function () {
   Route::get("/top-popular", [MediaController::class, "getTopPopularMedias"]); 
});

Route::prefix("movie")->middleware("auth:sanctum")->group(function () {
    Route::get("/by-listing-method", [MovieController::class, "getMoviesByListingMethod"]);
    Route::get("/by-title", [MovieController::class, "getMoviesByTitle"]);
    Route::get("/{id}", [MovieController::class, "getMovieDetails"]);
});

Route::prefix("tv-serie")->middleware("auth:sanctum")->group(function () {
    Route::get("/by-listing-method", [TVSerieController::class, "getTVSeriesByListingMethod"]);
    Route::get("/by-title", [TVSerieController::class, "getTVSeriesByTitle"]);
    Route::get("/{id}", [TVSerieController::class, "getTVSerieDetails"]);
});
