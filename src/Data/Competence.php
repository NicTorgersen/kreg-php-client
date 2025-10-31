<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Data;

class Competence
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $externalId = null,
        public readonly ?string $name = null,
        public readonly ?string $type = null,
        public readonly ?string $classification = null,
        public readonly ?string $issueDate = null,
        public readonly ?string $validUntilDate = null,
        public readonly ?string $instructor = null,
        public readonly ?string $instructorName = null,
        public readonly ?string $institution = null,
        public readonly ?string $bikTitle = null,
        public readonly ?string $registeredBy = null,
        public readonly ?string $modifiedTS = null,
        public readonly ?array $uso = null,
        public readonly ?array $document = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            externalId: $data['externalId'] ?? null,
            name: $data['name'] ?? null,
            type: $data['type'] ?? null,
            classification: $data['classification'] ?? null,
            issueDate: $data['issueDate'] ?? null,
            validUntilDate: $data['validUntilDate'] ?? null,
            instructor: $data['instructor'] ?? null,
            instructorName: $data['instructorName'] ?? null,
            institution: $data['institution'] ?? null,
            bikTitle: $data['bikTitle'] ?? null,
            registeredBy: $data['registeredBy'] ?? null,
            modifiedTS: $data['modifiedTS'] ?? null,
            uso: $data['uso'] ?? null,
            document: $data['document'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'externalId' => $this->externalId,
            'name' => $this->name,
            'type' => $this->type,
            'classification' => $this->classification,
            'issueDate' => $this->issueDate,
            'validUntilDate' => $this->validUntilDate,
            'instructor' => $this->instructor,
            'instructorName' => $this->instructorName,
            'institution' => $this->institution,
            'bikTitle' => $this->bikTitle,
            'uso' => $this->uso,
            'document' => $this->document,
        ], fn ($value) => $value !== null);
    }
}
