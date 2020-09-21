<?php

namespace Rawilk\LaravelUps;

use Illuminate\Support\ServiceProvider;
use Rawilk\LaravelUps\Commands\LaravelUpsCommand;

class LaravelUpsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-ups.php' => config_path('laravel-ups.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-ups'),
            ], 'views');

            if (! class_exists('CreatePackageTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_laravel_ups_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_laravel_ups_table.php'),
                ], 'migrations');
            }

            $this->commands([
                LaravelUpsCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-ups');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-ups.php', 'laravel-ups');
    }
}
