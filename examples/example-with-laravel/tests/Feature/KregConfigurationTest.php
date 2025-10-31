<?php

use NicTorgersen\KregApiSdk\KregClient;

test('kreg config file exists', function () {
    expect(config('kreg'))->toBeArray();
});

test('kreg config has all required keys', function () {
    $config = config('kreg');

    expect($config)->toHaveKeys([
        'system_token',
        'company_token',
        'base_url',
        'session_duration',
        'timeout',
    ]);
});

test('kreg config base_url has default value', function () {
    expect(config('kreg.base_url'))->toBe('https://api.kreg.no');
});

test('kreg config session_duration has default value', function () {
    expect(config('kreg.session_duration'))->toBe(86400);
});

test('kreg config timeout has default value', function () {
    expect(config('kreg.timeout'))->toBe(30);
});

test('can override kreg config at runtime', function () {
    config(['kreg.timeout' => 60]);

    expect(config('kreg.timeout'))->toBe(60);
});

test('kreg client can be instantiated with config values', function () {
    config([
        'kreg.base_url' => 'https://custom.api.kreg.no',
        'kreg.system_token' => 'test-system-token',
        'kreg.company_token' => 'test-company-token',
    ]);

    $kregConfig = \NicTorgersen\KregApiSdk\KregConfig::make(
        systemToken: config('kreg.system_token'),
        companyToken: config('kreg.company_token'),
        baseUrl: config('kreg.base_url'),
    );

    $client = KregClient::make($kregConfig);

    expect($client)->toBeInstanceOf(KregClient::class);
});

test('kreg config can be cached', function () {
    $this->artisan('config:cache')
        ->assertExitCode(0);

    // Clear the cache after test
    $this->artisan('config:clear')
        ->assertExitCode(0);
});

test('kreg config values can be set from environment variables', function () {
    putenv('KREG_SYSTEM_TOKEN=env-test-token');
    putenv('KREG_COMPANY_TOKEN=env-company-token');

    // Reload config
    app('config')->set('kreg.system_token', env('KREG_SYSTEM_TOKEN'));
    app('config')->set('kreg.company_token', env('KREG_COMPANY_TOKEN'));

    expect(config('kreg.system_token'))->toBe('env-test-token')
        ->and(config('kreg.company_token'))->toBe('env-company-token');

    // Cleanup
    putenv('KREG_SYSTEM_TOKEN');
    putenv('KREG_COMPANY_TOKEN');
});
