<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FirebaseAuth::class, function ($app) {
            // Create custom Guzzle client with proper configuration
            $handler = new CurlHandler();
            $stack = HandlerStack::create($handler);
            
            $httpClient = new Client([
                'handler' => $stack,
                'timeout' => 120, // 2 minutes timeout
                'connect_timeout' => 30,
                'verify' => false, // Disable SSL verification (for development)
                'http_errors' => false,
            ]);

            $path = config('firebase.projects.' . config('firebase.default') . '.credentials') ?: base_path('ensat-gestion-etudiants-firebase-adminsdk.json');

            if (!$path || !file_exists($path)) {
                throw new \InvalidArgumentException('Firebase credentials file not found at: ' . $path);
            }

            $factory = (new Factory)
                ->withServiceAccount($path)
                ->withHttpClient($httpClient);

            return $factory->createAuth();
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