<?php

declare(strict_types=1);

use NicTorgersen\KregApiSdk\Facades\Kreg;
use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\Resources\CatalogResource;
use NicTorgersen\KregApiSdk\Resources\CompaniesResource;
use NicTorgersen\KregApiSdk\Resources\CompetenceResource;
use NicTorgersen\KregApiSdk\Resources\DocumentResource;
use NicTorgersen\KregApiSdk\Resources\PersonResource;

test('facade resolves to KregClient instance', function () {
    $instance = Kreg::getFacadeRoot();

    expect($instance)->toBeInstanceOf(KregClient::class);
});

test('facade can access person resource', function () {
    $resource = Kreg::person();

    expect($resource)->toBeInstanceOf(PersonResource::class);
});

test('facade can access competence resource', function () {
    $resource = Kreg::competence();

    expect($resource)->toBeInstanceOf(CompetenceResource::class);
});

test('facade can access document resource', function () {
    $resource = Kreg::document();

    expect($resource)->toBeInstanceOf(DocumentResource::class);
});

test('facade can access catalog resource', function () {
    $resource = Kreg::catalog();

    expect($resource)->toBeInstanceOf(CatalogResource::class);
});

test('facade can access companies resource', function () {
    $resource = Kreg::companies();

    expect($resource)->toBeInstanceOf(CompaniesResource::class);
});

test('facade resolves to same instance', function () {
    $instance1 = Kreg::getFacadeRoot();
    $instance2 = Kreg::getFacadeRoot();

    expect($instance1)->toBe($instance2);
});
