<?php

namespace HeavenlyTours;

use HeavenlyTours\Contracts\HeavenlyToursApiInterface;
use Illuminate\Support\ServiceProvider;

class HeavenlyToursServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {


        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('config.php'),
            ], 'config');

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'heavenlyTours');
        $this->app->bind(HeavenlyToursApiInterface::class, HeavenlyToursApi::class);
    }
}
