<?php

namespace Kopou\SESEngine;

use Kopou\SESEngine\Services\SesMailer;
use Illuminate\Support\ServiceProvider;

class KopouSESEngineServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('kopou-ses-engine', function () {
            return new SesMailer();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/kopousesengine.php',
            'kopousesengine'
        );
    }

    public function boot()
    {
        // $this->publishes([
        //     __DIR__ . '/../config/kopousesengine.php' => config_path('kopousesengine.php'),
        // ], 'kopousesengine-config');

        $this->publishes([
            __DIR__ . '/../config/kopousesengine.php' => $this->app->configPath('kopousesengine.php'),
        ], 'kopou-config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }
}
