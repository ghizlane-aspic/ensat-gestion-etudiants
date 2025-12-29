<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
// use GuzzleHttp\Client;
// use GuzzleHttp\HandlerStack;
// use GuzzleHttp\Handler\CurlHandler;
use Kreait\Firebase\Http\HttpClientOptions;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    $this->app->singleton(FirebaseAuth::class, function ($app) {
      $configPath = config('firebase.projects.' . config('firebase.default') . '.credentials');

      // On force l'utilisation de base_path() pour transformer le nom du fichier en chemin complet
      $path = $configPath 
          ? base_path($configPath) 
          : base_path('ensat-gestion-etudiants-firebase-adminsdk.json');
        if (!$path || !file_exists($path)) {
            throw new \InvalidArgumentException('Firebase credentials file not found at: ' . $path);
        }
        // Configuration HTTP avec HttpClientOptions (nouvelle API)
        $httpClientOptions = \Kreait\Firebase\Http\HttpClientOptions::default()
            ->withTimeOut(120) // 2 minutes timeout
            ->withGuzzleConfigOptions([
                'connect_timeout' => 30,
                'verify' => false, // Désactiver SSL en développement
                'http_errors' => false,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ],
            ]);
        $factory = (new \Kreait\Firebase\Factory)
            ->withServiceAccount($path)
            ->withHttpClientOptions($httpClientOptions);
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