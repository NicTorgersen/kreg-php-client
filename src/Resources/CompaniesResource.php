<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Resources;

use NicTorgersen\KregApiSdk\Data\Company;
use NicTorgersen\KregApiSdk\KregClient;

class CompaniesResource
{
    public function __construct(
        private readonly KregClient $client,
    ) {}

    public function listActive(): array
    {
        $response = $this->client->request('KR_Companies', [
            'function' => 'ListActive',
        ]);

        return array_map(
            fn ($company) => Company::fromArray($company),
            $response['companies'] ?? []
        );
    }
}
