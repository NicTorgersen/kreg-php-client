<?php

declare(strict_types=1);

test('can create person', function () {
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

    $personId = $client->person()->create(
        firstName: 'Arne',
        lastName: 'Jacobsen',
        externalId: 'ixmal001',
        identityNumber: '12087211312',
    );

    expect($personId)->toBe('test-person-id');
});

test('can get person', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'person' => [
                'id' => 'test-person-id',
                'firstName' => 'Arne',
                'lastName' => 'Jacobsen',
                'identityNumber' => '12087211312',
                'externalId' => 'ixmal001',
                'competence' => [],
                'documents' => [],
                'submittedCompetence' => [],
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $person = $client->person()->get(personId: 'test-person-id');

    expect($person->firstName)->toBe('Arne')
        ->and($person->lastName)->toBe('Jacobsen')
        ->and($person->id)->toBe('test-person-id');
});

test('can find person', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'personId' => 'found-person-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $personId = $client->person()->find(
        firstName: 'Ola',
        lastName: 'Nordman',
        birthDate: '1988-11-18',
    );

    expect($personId)->toBe('found-person-id');
});

test('can check person competence', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'success' => true,
            'name' => 'Prosjekt fareblind',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $result = $client->person()->check(
        personId: 'test-person-id',
        code: 'PFB',
    );

    expect($result['success'])->toBeTrue()
        ->and($result['name'])->toBe('Prosjekt fareblind');
});

test('can confirm person', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'success' => true,
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $success = $client->person()->confirm('test-person-id');

    expect($success)->toBeTrue();
});

test('can list persons', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'persons' => [
                [
                    'id' => 'person-1',
                    'firstName' => 'Henrik',
                    'lastName' => 'Hagen',
                    'externalId' => 'heha002',
                    'competence' => [],
                    'documents' => [],
                    'submittedCompetence' => [],
                ],
                [
                    'id' => 'person-2',
                    'firstName' => 'Ivar',
                    'lastName' => 'Husmo',
                    'externalId' => 'ivhu001',
                    'competence' => [],
                    'documents' => [],
                    'submittedCompetence' => [],
                ],
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $persons = $client->person()->list();

    expect($persons)->toHaveCount(2)
        ->and($persons[0]->firstName)->toBe('Henrik')
        ->and($persons[1]->firstName)->toBe('Ivar');
});

test('can delete person', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->person()->delete(personId: 'test-person-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('can upload person image', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->person()->uploadImage(
        personId: 'test-person-id',
        filename: 'photo.jpg',
        base64Content: 'base64encodedcontent',
    );

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('can update person', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Person' => [
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->person()->update(
        personId: 'test-person-id',
        firstName: 'Arne Olav',
    );

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});
