<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\Ups\UpsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        $this->loadEnvironmentVariables();

        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            UpsServiceProvider::class,
        ];
    }

    protected function loadEnvironmentVariables(): void
    {
        // File won't exist when running tests on GitHub actions.
        // .env variables are loaded in through workflow file instead
        // utilizing GitHub secrets.
        if (! file_exists(__DIR__.'/../.env')) {
            return;
        }

        $dotEnv = Dotenv::createImmutable(__DIR__.'/..');

        $dotEnv->load();
    }
}
