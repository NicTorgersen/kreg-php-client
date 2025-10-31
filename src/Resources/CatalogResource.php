<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Resources;

use NicTorgersen\KregApiSdk\Data\CatalogCompetence;
use NicTorgersen\KregApiSdk\KregClient;

class CatalogResource
{
    public function __construct(
        private readonly KregClient $client,
    ) {}

    public function list(): array
    {
        $response = $this->client->request('KR_Catalog', [
            'function' => 'List',
        ]);

        return array_map(
            fn ($comp) => CatalogCompetence::fromArray($comp),
            $response['competence'] ?? []
        );
    }
}
