<?php

declare(strict_types=1);

use NicTorgersen\KregApiSdk\Exceptions\Kregception;

test('can create session', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $sessionId = $client->createSession();

    expect($sessionId)->toBe('test-session-id');
});

test('throws exception on failed session creation', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'result' => ['code' => -1, 'detailed' => 'Authentication failed'],
        ],
    ]);

    $client->createSession();
})->throws(Kregception::class);

test('generates correct session key', function () {
    $systemToken = '6BA8C7E7F68';
    $companyToken = 'B3BFE024C4E146C8AE29CDC3C7B9047F';

    $config = \NicTorgersen\KregApiSdk\KregConfig::make(
        systemToken: $systemToken,
        companyToken: $companyToken,
    );

    \Illuminate\Support\Facades\Http::fake([
        '*/KR_Session' => function ($request) use ($systemToken, $companyToken) {
            $body = $request->data();
            $epoch = $body['epoch'];
            $expectedKey = hash('sha256', $systemToken.$companyToken.$epoch.'KR_Session');

            expect($body['key'])->toBe($expectedKey);

            return [
                'sessionId' => 'test-session-id',
                'result' => ['code' => 0, 'detailed' => ''],
            ];
        },
    ]);

    $client = \NicTorgersen\KregApiSdk\KregClient::make($config);
    $client->createSession();
});

test('reuses valid session', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'personId' => 'test-person-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->createSession();
    $sessionId1 = $client->getSessionId();
    $sessionId2 = $client->getSessionId();

    expect($sessionId1)->toBe($sessionId2);
});

test('can make authenticated request', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'personId' => 'test-person-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $response = $client->request('KR_Person', [
        'function' => 'Create',
        'person' => ['firstName' => 'Test'],
    ]);

    expect($response)->toHaveKey('personId');
});
