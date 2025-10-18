<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TVSerieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () =>response()->json(
    ['message' => 'Bem vindo a Laon-Catalog! Você deve estar logado com um usuário para usar a maioria dos recursos. Procure as rotas createUser/login.']
));

Route::prefix("user")->group(function () {
    Route::post("", [UserController::class, "createUser"]);
    Route::post("/login", [UserController::class, "login"]);
    Route::post("/logout/{id}", [UserController::class, "logout"])->middleware("auth:sanctum");
});

Route::prefix("media")->group(function () {
    Route::get("/top-popular", [MediaController::class, "getTopPopularMedias"]); 
    Route::get("/listing-method/{media_type}", [MediaController::class, "getListingMethods"]); 

    Route::prefix("list")->middleware("auth:sanctum")->group(function () {
        Route::get("/by-user/{user_id}", [MediaController::class, "getMediaListsByUser"]);
        Route::get("/{id}", [MediaController::class, "getMediaListDetails"]);
        Route::post("", [MediaController::class, "createMediaList"]);
        Route::patch("/{id}/add-medias", [MediaController::class, "addMediasIntoMediaList"]);
        Route::delete("/{id}/remove-medias", [MediaController::class, "deleteMediasFromMediaList"]);
        Route::delete("/{id}", [MediaController::class, "deleteMediaList"]);
    });
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