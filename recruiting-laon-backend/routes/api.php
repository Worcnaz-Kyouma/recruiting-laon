<?php

use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Sanctum!!
Route::prefix("media")->group(function () {
   Route::get("/top-popular", [MediaController::class, "getTopPopularMedias"]); 
});