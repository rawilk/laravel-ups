<?php

namespace Rawilk\LaravelUps\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rawilk\LaravelUps\LaravelUps
 */
class LaravelUpsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-ups';
    }
}
