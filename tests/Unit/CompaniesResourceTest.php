<?php

declare(strict_types=1);

test('can list active companies', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Companies' => [
            'companies' => [
                [
                    'id' => 5,
                    'name' => 'Selskapsnavn AS',
                    'enterpriseNumber' => '123456789',
                    'count' => 195,
                    'lastModifiedTS' => '2024-03-12T09:56:23.106Z',
                ],
                [
                    'id' => 7,
                    'name' => 'Firmanavn AS',
                    'enterpriseNumber' => '987456321',
                    'count' => 354,
                    'lastModifiedTS' => '2023-08-24T13:25:45.639Z',
                ],
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $companies = $client->companies()->listActive();

    expect($companies)->toHaveCount(2)
        ->and($companies[0]->name)->toBe('Selskapsnavn AS')
        ->and($companies[0]->enterpriseNumber)->toBe('123456789')
        ->and($companies[0]->count)->toBe(195)
        ->and($companies[1]->name)->toBe('Firmanavn AS');
});
