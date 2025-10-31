<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk;

class KregConfig
{
    public function __construct(
        public readonly string $systemToken,
        public readonly string $companyToken,
        public readonly string $baseUrl = 'https://kreg.sr.no/kreg/v1/',
        public readonly int $timeout = 30,
        public readonly int $sessionDuration = 86400, // 24 hours in seconds
    ) {}

    public static function make(
        string $systemToken,
        string $companyToken,
        ?string $baseUrl = null,
        ?int $timeout = null,
        ?int $sessionDuration = null
    ): self {
        return new self(
            systemToken: $systemToken,
            companyToken: $companyToken,
            baseUrl: $baseUrl ?? 'https://kreg.sr.no/kreg/v1/',
            timeout: $timeout ?? 30,
            sessionDuration: $sessionDuration ?? 86400,
        );
    }
}
