<?php

namespace Kopou\SESEngine;

use Illuminate\Support\ServiceProvider;

class KopouSESEngineServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/kopousesengine.php',
            'kopousesengine'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/kopousesengine.php' => config_path('kopousesengine.php'),
        ], 'kopousesengine-config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
