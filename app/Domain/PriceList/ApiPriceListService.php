<?php
namespace LaraCall\Domain\PriceList;

use A2bApiClient\Api\Instances\CountryInstance;
use A2bApiClient\Client;
use Cache;
use Carbon\Carbon;

class ApiPriceListService implements PriceListService
{
    const CACHE_KEY = 'price_list_countries';

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return CountryInstance[]
     */
    public function getCountries(): array
    {
        $countries = Cache::get(self::CACHE_KEY);

        if ( ! $countries) {
            $countries = $this->client->getPriceList()->getCountries();
            Cache::forever(self::CACHE_KEY, $countries);
        }

        return $countries;
    }

    /**
     * @param int    $tariffId
     * @param string $countryCode
     *
     * @return array
     */
    public function getRates(int $tariffId, string $countryCode = null): array
    {
        if ($countryCode) {
            $countryCode = strtoupper($countryCode);
        }

        $key = "price_list:rates:{$tariffId}";
        if ($countryCode) {
            $key .= ":{$countryCode}";
        }

        $rates = Cache::get($key);
        if ( ! $rates) {
            $rates = $this->client->getPriceList()->getRates($tariffId, $countryCode);
            Cache::add($key, $rates, Carbon::now()->addDays(1));
        }

        return $rates;
    }
}
