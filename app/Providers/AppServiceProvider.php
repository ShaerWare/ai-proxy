<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gemini\Client;
use Gemini;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the Gemini Client as a singleton
        $this->app->singleton(Client::class, function ($app) {
            $apiKey = config('gemini.api_key');
            if (!$apiKey) {
                throw new \Exception('GEMINI_API_KEY is not set in .env file.');
            }
            return Gemini::client($apiKey);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}