<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TMDB API Configuration
    |--------------------------------------------------------------------------
    |
    | TMDB its an application that offers an REST API to fetch shows and movies.
    |
    */

    'base_url' => env('TMDB_BASE_URL'),
    'api_version' => env('TMDB_API_VERSION'),
    'api_key' => env('TMDB_API_KEY'),

];
