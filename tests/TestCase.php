<?php

namespace Rawilk\Ups\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\Ups\UpsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            UpsServiceProvider::class,
        ];
    }
}
