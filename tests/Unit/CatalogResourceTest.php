<?php

declare(strict_types=1);

test('can list catalog competences', function () {
    $client = createTestClient([
        '*/KR_Session' => [
            'sessionId' => 'test-session-id',
            'result' => ['code' => 0, 'detailed' => ''],
        ],
        '*/KR_Catalog' => [
            'competence' => [
                [
                    'id' => 1,
                    'name' => 'Tårnkran',
                    'classification' => 'G2',
                    'type' => 'Sertifisert',
                    'typeName' => 'Sertifisert sikkerhetsopplæring',
                ],
                [
                    'id' => 2,
                    'name' => 'Sving og portalkran',
                    'classification' => 'G3',
                    'type' => 'Sertifisert',
                    'typeName' => 'Sertifisert sikkerhetsopplæring',
                ],
            ],
            'result' => ['code' => 0, 'detailed' => ''],
        ],
    ]);

    $competences = $client->catalog()->list();

    expect($competences)->toHaveCount(2)
        ->and($competences[0]->name)->toBe('Tårnkran')
        ->and($competences[0]->classification)->toBe('G2')
        ->and($competences[1]->name)->toBe('Sving og portalkran');
});
