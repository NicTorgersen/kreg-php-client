<?php

declare(strict_types=1);

namespace NicTorgersen\KregApiSdk\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \NicTorgersen\KregApiSdk\Resources\PersonResource person()
 * @method static \NicTorgersen\KregApiSdk\Resources\CompetenceResource competence()
 * @method static \NicTorgersen\KregApiSdk\Resources\DocumentResource document()
 * @method static \NicTorgersen\KregApiSdk\Resources\CatalogResource catalog()
 * @method static \NicTorgersen\KregApiSdk\Resources\CompaniesResource companies()
 * @method static string createSession()
 * @method static string getSessionId()
 * @method static array request(string $method, array $data = [])
 *
 * @see \NicTorgersen\KregApiSdk\KregClient
 */
class Kreg extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'kreg';
    }
}
