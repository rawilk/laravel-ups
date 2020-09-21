<?php

namespace Rawilk\Ups;

use Illuminate\Support\ServiceProvider;

class UpsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ups.php' => config_path('ups.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ups.php', 'ups');
    }
}
