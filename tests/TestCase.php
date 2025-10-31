<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Tests;

use NicTorgersen\KregApiSdk\KregServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            KregServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        // Setup default configuration
        config()->set('kreg.system_token', 'test-system-token');
        config()->set('kreg.company_token', 'test-company-token');
    }
}
