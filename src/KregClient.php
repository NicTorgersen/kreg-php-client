<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;
use NicTorgersen\KregApiSdk\Resources\CatalogResource;
use NicTorgersen\KregApiSdk\Resources\CompaniesResource;
use NicTorgersen\KregApiSdk\Resources\CompetenceResource;
use NicTorgersen\KregApiSdk\Resources\DocumentResource;
use NicTorgersen\KregApiSdk\Resources\PersonResource;

class KregClient
{
    private ?string $sessionId = null;

    private ?int $sessionCreatedAt = null;

    public function __construct(
        private readonly KregConfig $config,
    ) {}

    public static function make(KregConfig $config): self
    {
        return new self($config);
    }

    public function person(): PersonResource
    {
        return new PersonResource($this);
    }

    public function competence(): CompetenceResource
    {
        return new CompetenceResource($this);
    }

    public function document(): DocumentResource
    {
        return new DocumentResource($this);
    }

    public function catalog(): CatalogResource
    {
        return new CatalogResource($this);
    }

    public function companies(): CompaniesResource
    {
        return new CompaniesResource($this);
    }

    public function createSession(): string
    {
        $epoch = (string) time();
        $key = $this->generateSessionKey($epoch);

        $response = $this->http()->post('KR_Session', [
            'companyToken' => $this->config->companyToken,
            'epoch' => $epoch,
            'key' => $key,
        ]);

        $data = $response->json();

        if (($data['result']['code'] ?? 1) !== 0) {
            throw Kregception::fromResponse($data['result']);
        }

        $this->sessionId = $data['sessionId'];
        $this->sessionCreatedAt = time();

        return $this->sessionId;
    }

    public function getSessionId(): string
    {
        if ($this->sessionId === null || $this->isSessionExpired()) {
            $this->createSession();
        }

        return $this->sessionId;
    }

    public function request(string $method, array $data = []): array
    {
        $sessionId = $this->getSessionId();
        $epoch = (string) time();
        $key = $this->generateMethodKey($sessionId, $epoch, $method);

        $payload = array_merge([
            'sessionId' => $sessionId,
            'epoch' => $epoch,
            'key' => $key,
        ], $data);

        $response = $this->http()->post($method, $payload);
        $responseData = $response->json();

        if (($responseData['result']['code'] ?? 1) !== 0) {
            throw Kregception::fromResponse($responseData['result']);
        }

        return $responseData;
    }

    private function generateSessionKey(string $epoch): string
    {
        $source = $this->config->systemToken
            .$this->config->companyToken
            .$epoch
            .'KR_Session';

        return hash('sha256', $source);
    }

    private function generateMethodKey(string $sessionId, string $epoch, string $method): string
    {
        $source = $sessionId.$epoch.$method;

        return hash('sha256', $source);
    }

    private function isSessionExpired(): bool
    {
        if ($this->sessionCreatedAt === null) {
            return true;
        }

        return (time() - $this->sessionCreatedAt) >= $this->config->sessionDuration;
    }

    private function http(): PendingRequest
    {
        return Http::baseUrl($this->config->baseUrl)
            ->timeout($this->config->timeout)
            ->acceptJson()
            ->contentType('application/json');
    }
}
