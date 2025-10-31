<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Resources;

use NicTorgersen\KregApiSdk\Data\Document;
use NicTorgersen\KregApiSdk\KregClient;

class DocumentResource
{
    public function __construct(
        private readonly KregClient $client,
    ) {}

    public function create(
        string $personId,
        string $filename,
        string $base64Content,
    ): void {
        $this->client->request('KR_Document', [
            'function' => 'Create',
            'personId' => $personId,
            'filename' => $filename,
            'document' => $base64Content,
        ]);
    }

    public function list(string $personId): array
    {
        $response = $this->client->request('KR_Document', [
            'function' => 'List',
            'personId' => $personId,
        ]);

        return array_map(
            fn ($doc) => Document::fromArray($doc),
            $response['documents'] ?? []
        );
    }

    public function get(string $personId, string $documentId): Document
    {
        $response = $this->client->request('KR_Document', [
            'function' => 'Get',
            'personId' => $personId,
            'documentId' => $documentId,
        ]);

        return Document::fromArray($response['document']);
    }

    public function delete(string $personId, string $documentId): void
    {
        $this->client->request('KR_Document', [
            'function' => 'Delete',
            'personId' => $personId,
            'documentId' => $documentId,
        ]);
    }
}
