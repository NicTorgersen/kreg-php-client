<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Resources;

use NicTorgersen\KregApiSdk\Data\Person;
use NicTorgersen\KregApiSdk\KregClient;

class PersonResource
{
    public function __construct(
        private readonly KregClient $client,
    ) {}

    public function create(
        string $firstName,
        string $lastName,
        string $externalId,
        string $identityNumber,
        ?string $mobile = null,
        ?string $enterpriseNumber = null,
        ?string $hmsNumber = null,
    ): string {
        $response = $this->client->request('KR_Person', [
            'function' => 'Create',
            'person' => array_filter([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'externalId' => $externalId,
                'identityNumber' => $identityNumber,
                'mobile' => $mobile,
                'enterpriseNumber' => $enterpriseNumber,
                'hmsNumber' => $hmsNumber,
            ], fn ($value) => $value !== null),
        ]);

        return $response['personId'];
    }

    public function get(
        ?string $personId = null,
        ?string $externalId = null,
        bool $remapTimestamp = false
    ): Person {
        $response = $this->client->request('KR_Person', array_filter([
            'function' => 'Get',
            'personId' => $personId,
            'externalId' => $externalId,
            'remapTimestamp' => $remapTimestamp,
        ], fn ($value) => $value !== null && $value !== false));

        return Person::fromArray($response['person']);
    }

    public function find(
        string $firstName,
        string $lastName,
        ?string $birthDate = null,
        ?string $identityNumber = null,
        ?string $mobileNumber = null,
        ?string $hmsNumber = null,
    ): string {
        $response = $this->client->request('KR_Person', array_filter([
            'function' => 'Find',
            'firstName' => $firstName,
            'lastName' => $lastName,
            'birthDate' => $birthDate,
            'identityNumber' => $identityNumber,
            'mobileNumber' => $mobileNumber,
            'hmsNumber' => $hmsNumber,
        ], fn ($value) => $value !== null));

        return $response['personId'];
    }

    public function check(
        string $personId,
        ?string $code = null,
        ?int $catalogId = null,
    ): array {
        $response = $this->client->request('KR_Person', array_filter([
            'function' => 'Check',
            'personId' => $personId,
            'code' => $code,
            'catalogId' => $catalogId,
        ], fn ($value) => $value !== null));

        return [
            'success' => $response['success'] ?? false,
            'name' => $response['name'] ?? null,
        ];
    }

    public function confirm(string $personId): bool
    {
        $response = $this->client->request('KR_Person', [
            'function' => 'Confirm',
            'personId' => $personId,
        ]);

        return $response['success'] ?? false;
    }

    public function list(
        string $status = 'All',
        ?string $fromTS = null,
    ): array {
        $response = $this->client->request('KR_Person', array_filter([
            'function' => 'List',
            'status' => $status,
            'fromTS' => $fromTS,
        ], fn ($value) => $value !== null));

        return array_map(
            fn ($person) => Person::fromArray($person),
            $response['persons'] ?? []
        );
    }

    public function delete(
        ?string $personId = null,
        ?string $externalId = null,
    ): void {
        $this->client->request('KR_Person', array_filter([
            'function' => 'Delete',
            'personId' => $personId,
            'externalId' => $externalId,
        ], fn ($value) => $value !== null));
    }

    public function uploadImage(
        string $personId,
        string $filename,
        string $base64Content,
    ): void {
        $this->client->request('KR_Person', [
            'function' => 'Image',
            'personId' => $personId,
            'image' => [
                'name' => $filename,
                'content' => $base64Content,
            ],
        ]);
    }

    public function update(
        string $personId,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $externalId = null,
        ?string $identityNumber = null,
        ?string $mobile = null,
        ?string $enterpriseNumber = null,
        ?string $hmsNumber = null,
    ): void {
        $this->client->request('KR_Person', [
            'function' => 'Update',
            'personId' => $personId,
            'person' => array_filter([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'externalId' => $externalId,
                'identityNumber' => $identityNumber,
                'mobile' => $mobile,
                'enterpriseNumber' => $enterpriseNumber,
                'hmsNumber' => $hmsNumber,
            ], fn ($value) => $value !== null),
        ]);
    }
}
