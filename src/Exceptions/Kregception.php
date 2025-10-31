<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Exceptions;

use Exception;

class Kregception extends Exception
{
    public function __construct(
        string $message = '',
        public readonly int $kregCode = 0,
        public readonly string $detailed = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponse(array $result): self
    {
        $code = $result['code'] ?? 0;
        $detailed = $result['detailed'] ?? '';

        return match ($code) {
            -1 => new KregAuthenticationException($detailed, $code, $detailed),
            -2 => new KregValidationException($detailed, $code, $detailed),
            -3 => new KregNotFoundException($detailed, $code, $detailed),
            default => new self($detailed ?: 'Unknown KREG API error', $code, $detailed),
        };
    }
}
