<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class KregServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('kreg-php-api')
            ->hasConfigFile('kreg');
    }

    public function registeringPackage(): void
    {
        $this->app->singleton('kreg', function ($app) {
            $config = KregConfig::make(
                systemToken: config('kreg.system_token'),
                companyToken: config('kreg.company_token'),
                baseUrl: config('kreg.base_url', 'https://api.kreg.no'),
                sessionDuration: config('kreg.session_duration', 86400),
                timeout: config('kreg.timeout', 30),
            );

            return KregClient::make($config);
        });

        $this->app->alias('kreg', KregClient::class);
    }
}
