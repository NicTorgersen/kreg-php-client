<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Resources;

use NicTorgersen\KregApiSdk\Data\Competence;
use NicTorgersen\KregApiSdk\KregClient;

class CompetenceResource
{
    public function __construct(
        private readonly KregClient $client,
    ) {}

    public function create(
        string $personId,
        string $externalId,
        string $name,
        ?string $type = null,
        ?string $issueDate = null,
        ?string $instructor = null,
        ?string $institution = null,
        ?string $bikTitle = null,
        ?string $validUntilDate = null,
        ?array $uso = null,
        ?array $document = null,
    ): string {
        $response = $this->client->request('KR_Competence', [
            'function' => 'Create',
            'personId' => $personId,
            'competence' => array_filter([
                'externalId' => $externalId,
                'name' => $name,
                'type' => $type,
                'issueDate' => $issueDate,
                'instructor' => $instructor,
                'institution' => $institution,
                'bikTitle' => $bikTitle,
                'validUntilDate' => $validUntilDate,
                'uso' => $uso,
                'document' => $document,
            ], fn ($value) => $value !== null),
        ]);

        return $response['competenceId'];
    }

    public function get(string $personId, string $competenceId): Competence
    {
        $response = $this->client->request('KR_Competence', [
            'function' => 'Get',
            'personId' => $personId,
            'competenceId' => $competenceId,
        ]);

        return Competence::fromArray($response['competence']);
    }

    public function list(string $personId): array
    {
        $response = $this->client->request('KR_Competence', [
            'function' => 'List',
            'personId' => $personId,
        ]);

        return [
            'competence' => array_map(
                fn ($c) => Competence::fromArray($c),
                $response['competence'] ?? []
            ),
            'submittedCompetence' => array_map(
                fn ($c) => Competence::fromArray($c),
                $response['submittedCompetence'] ?? []
            ),
        ];
    }

    public function delete(string $personId, string $competenceId): void
    {
        $this->client->request('KR_Competence', [
            'function' => 'Delete',
            'personId' => $personId,
            'competenceId' => $competenceId,
        ]);
    }

    public function update(
        string $personId,
        string $competenceId,
        array $competenceData,
    ): void {
        $this->client->request('KR_Competence', [
            'function' => 'Update',
            'personId' => $personId,
            'competenceId' => $competenceId,
            'competence' => $competenceData,
        ]);
    }
}
