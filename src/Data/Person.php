<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Data;

class Person
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $identityNumber = null,
        public readonly ?string $externalId = null,
        public readonly ?string $mobile = null,
        public readonly ?string $enterpriseNumber = null,
        public readonly ?string $hmsNumber = null,
        public readonly ?string $status = null,
        public readonly ?string $modifiedTS = null,
        public readonly array $competence = [],
        public readonly array $documents = [],
        public readonly array $submittedCompetence = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            identityNumber: $data['identityNumber'] ?? null,
            externalId: $data['externalId'] ?? null,
            mobile: $data['mobile'] ?? null,
            enterpriseNumber: $data['enterpriseNumber'] ?? null,
            hmsNumber: $data['hmsNumber'] ?? null,
            status: $data['status'] ?? null,
            modifiedTS: $data['modifiedTS'] ?? null,
            competence: array_map(
                fn ($c) => Competence::fromArray($c),
                $data['competence'] ?? []
            ),
            documents: array_map(
                fn ($d) => Document::fromArray($d),
                $data['documents'] ?? []
            ),
            submittedCompetence: array_map(
                fn ($c) => Competence::fromArray($c),
                $data['submittedCompetence'] ?? []
            ),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'identityNumber' => $this->identityNumber,
            'externalId' => $this->externalId,
            'mobile' => $this->mobile,
            'enterpriseNumber' => $this->enterpriseNumber,
            'hmsNumber' => $this->hmsNumber,
        ], fn ($value) => $value !== null);
    }
}
