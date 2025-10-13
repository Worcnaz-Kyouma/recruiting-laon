<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TVSerieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Sanctum!!
Route::prefix("media")->group(function () {
   Route::get("/top-popular", [MediaController::class, "getTopPopularMedias"]); 
});

// TODO: Make users not send and bad params a user error, expected
Route::prefix("movie")->group(function () {
    Route::get("/by-listing-method", [MovieController::class, "getMoviesByListingMethod"]);
    Route::get("/by-title", [MovieController::class, "getMoviesByTitle"]);
    Route::get("/{id}", [MovieController::class, "getMovieDetails"]);
});

Route::prefix("tv-serie")->group(function () {
    Route::get("/by-listing-method", [TVSerieController::class, "getTVSeriesByListingMethod"]);
    Route::get("/by-title", [TVSerieController::class, "getTVSeriesByTitle"]);
    Route::get("/{id}", [TVSerieController::class, "getTVSerieDetails"]);
});
