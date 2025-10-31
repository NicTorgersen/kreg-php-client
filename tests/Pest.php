<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;
use NicTorgersen\KregApiSdk\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function createTestClient(array $responses = []): KregClient
{
    $config = KregConfig::make(
        systemToken: 'test-system-token',
        companyToken: 'test-company-token',
    );

    Http::fake($responses);

    return KregClient::make($config);
}
