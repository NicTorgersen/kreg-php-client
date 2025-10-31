<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Data;

class Document
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $filename = null,
        public readonly ?int $filesize = null,
        public readonly ?string $content = null,
        public readonly ?string $modifiedTS = null,
        public readonly ?string $feedbackCode = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            filename: $data['filename'] ?? null,
            filesize: $data['filesize'] ?? null,
            content: $data['content'] ?? null,
            modifiedTS: $data['modifiedTS'] ?? null,
            feedbackCode: $data['feedbackCode'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'filename' => $this->filename,
            'content' => $this->content,
        ], fn ($value) => $value !== null);
    }
}
