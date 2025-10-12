<?php

namespace App\Providers;

use App\Services\TMDBApiService;
use Illuminate\Support\ServiceProvider;

class TMDBApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {
        $this->app->singleton(TMDBApiService::class, function ($app) {
            $baseUrl = config("tmdb.base_url");
            $apiVersion = config("tmdb.api_version");
            $apiKey = config("tmdb.api_key");
            
            return new TMDBApiService(
                $baseUrl, $apiVersion, $apiKey
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
