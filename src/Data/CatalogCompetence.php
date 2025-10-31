<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Data;

class CatalogCompetence
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $classification = null,
        public readonly ?string $type = null,
        public readonly ?string $typeName = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            classification: $data['classification'] ?? null,
            type: $data['type'] ?? null,
            typeName: $data['typeName'] ?? null,
        );
    }
}
