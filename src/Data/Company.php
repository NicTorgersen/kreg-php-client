<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Data;

class Company
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $enterpriseNumber,
        public readonly int $count,
        public readonly string $lastModifiedTS,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            enterpriseNumber: $data['enterpriseNumber'],
            count: $data['count'],
            lastModifiedTS: $data['lastModifiedTS'],
        );
    }
}
