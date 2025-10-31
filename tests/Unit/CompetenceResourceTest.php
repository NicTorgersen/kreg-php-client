<?php

declare(strict_types=1);

test('can create competence', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Competence' => [
            'competenceId' => 'test-competence-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $competenceId = $client->competence()->create(
        personId: 'test-person-id',
        externalId: '248',
        name: 'Site introduction',
        type: 'Annen',
        issueDate: '2024-01-15',
    );

    expect($competenceId)->toBe('test-competence-id');
});

test('can get competence', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Competence' => [
            'competence' => [
                'id' => 'test-competence-id',
                'name' => 'T2 Skyvemast- og støttebenstruck',
                'type' => 'Sertifisert',
                'classification' => 'T2',
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $competence = $client->competence()->get(
        personId: 'test-person-id',
        competenceId: 'test-competence-id',
    );

    expect($competence->name)->toBe('T2 Skyvemast- og støttebenstruck')
        ->and($competence->type)->toBe('Sertifisert')
        ->and($competence->classification)->toBe('T2');
});

test('can list competences', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Competence' => [
            'competence' => [
                [
                    'id' => 'comp-1',
                    'name' => 'T2 Skyvemast- og støttebenstruck',
                    'type' => 'Sertifisert',
                ],
            ],
            'submittedCompetence' => [
                [
                    'id' => 'comp-2',
                    'name' => 'T4 Motvektstruck tom 10 tonn',
                    'type' => 'Sertifisert',
                ],
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $result = $client->competence()->list('test-person-id');

    expect($result['competence'])->toHaveCount(1)
        ->and($result['submittedCompetence'])->toHaveCount(1)
        ->and($result['competence'][0]->name)->toBe('T2 Skyvemast- og støttebenstruck')
        ->and($result['submittedCompetence'][0]->name)->toBe('T4 Motvektstruck tom 10 tonn');
});

test('can delete competence', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Competence' => [
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->competence()->delete(
        personId: 'test-person-id',
        competenceId: 'test-competence-id',
    );

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('can update competence', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Competence' => [
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $client->competence()->update(
        personId: 'test-person-id',
        competenceId: 'test-competence-id',
        competenceData: [
            'name' => 'Updated name',
            'validUntilDate' => '2025-12-31',
        ],
    );

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});
