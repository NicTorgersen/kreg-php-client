<?php

use NicTorgersen\KregApiSdk\Facades\Kreg;
use NicTorgersen\KregApiSdk\KregClient;

beforeEach(function () {
    config([
        'kreg.system_token' => 'test-system-token',
        'kreg.company_token' => 'test-company-token',
        'kreg.base_url' => 'https://test.api.kreg.no',
    ]);
});

test('kreg service provider is registered', function () {
    expect(app()->getProviders(\NicTorgersen\KregApiSdk\KregServiceProvider::class))
        ->toHaveCount(1);
});

test('kreg client is bound in container', function () {
    expect(app()->bound('kreg'))->toBeTrue()
        ->and(app('kreg'))->toBeInstanceOf(KregClient::class);
});

test('kreg facade resolves to client instance', function () {
    $instance = Kreg::getFacadeRoot();

    expect($instance)->toBeInstanceOf(KregClient::class);
});

test('kreg facade is singleton', function () {
    $instance1 = Kreg::getFacadeRoot();
    $instance2 = Kreg::getFacadeRoot();

    expect($instance1)->toBe($instance2);
});

test('kreg config is loaded from laravel config', function () {
    config([
        'kreg.system_token' => 'test-system-token',
        'kreg.company_token' => 'test-company-token',
        'kreg.base_url' => 'https://test.api.kreg.no',
    ]);

    $client = app('kreg');

    expect($client)->toBeInstanceOf(KregClient::class);
});

test('can access person resource through facade', function () {
    $resource = Kreg::person();

    expect($resource)->toBeInstanceOf(\NicTorgersen\KregApiSdk\Resources\PersonResource::class);
});

test('can access competence resource through facade', function () {
    $resource = Kreg::competence();

    expect($resource)->toBeInstanceOf(\NicTorgersen\KregApiSdk\Resources\CompetenceResource::class);
});

test('can access document resource through facade', function () {
    $resource = Kreg::document();

    expect($resource)->toBeInstanceOf(\NicTorgersen\KregApiSdk\Resources\DocumentResource::class);
});

test('can access catalog resource through facade', function () {
    $resource = Kreg::catalog();

    expect($resource)->toBeInstanceOf(\NicTorgersen\KregApiSdk\Resources\CatalogResource::class);
});

test('can access companies resource through facade', function () {
    $resource = Kreg::companies();

    expect($resource)->toBeInstanceOf(\NicTorgersen\KregApiSdk\Resources\CompaniesResource::class);
});

test('can resolve kreg client from container using dependency injection', function () {
    $client = app(KregClient::class);

    expect($client)->toBeInstanceOf(KregClient::class);
});

test('kreg client uses configuration from env', function () {
    config([
        'kreg.system_token' => 'env-system-token',
        'kreg.company_token' => 'env-company-token',
    ]);

    // Force rebind to pick up new config
    app()->forgetInstance('kreg');
    app()->singleton('kreg', function ($app) {
        $config = \NicTorgersen\KregApiSdk\KregConfig::make(
            systemToken: config('kreg.system_token'),
            companyToken: config('kreg.company_token'),
            baseUrl: config('kreg.base_url', 'https://api.kreg.no'),
            sessionDuration: config('kreg.session_duration', 86400),
            timeout: config('kreg.timeout', 30),
        );

        return \NicTorgersen\KregApiSdk\KregClient::make($config);
    });

    $client = app('kreg');

    expect($client)->toBeInstanceOf(KregClient::class);
});

test('kreg facade can be used in multiple tests without conflicts', function () {
    $instance1 = Kreg::person();
    $instance2 = Kreg::competence();

    expect($instance1)->toBeInstanceOf(\NicTorgersen\KregApiSdk\Resources\PersonResource::class)
        ->and($instance2)->toBeInstanceOf(\NicTorgersen\KregApiSdk\Resources\CompetenceResource::class);
});
