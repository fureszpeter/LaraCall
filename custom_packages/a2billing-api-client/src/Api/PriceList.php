<?php
namespace A2bApiClient\Api;

use A2bApiClient\Api\Instances\CountryInstance;
use A2bApiClient\Api\Instances\RateInstance;
use A2bApiClient\Exceptions\A2bApiException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

class PriceList
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return CountryInstance[]
     *
     * @throws A2bApiException
     */
    public function getCountries(): array
    {
        try {
            $response = $this->client->request('GET', "countries");

            $body = $response->getBody();

            $responseObjects = json_decode($body, true);

            $countries = [];
            foreach ($responseObjects as $responseObject) {
                $countries[] = new CountryInstance($responseObject);
            }

            return $countries;
        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }

    /**
     * @param int         $tariffId
     * @param string|null $countryCode
     *
     * @return RateInstance[]
     *
     * @throws A2bApiException
     */
    public function getRates(int $tariffId, string $countryCode = null): array
    {
        $countryPostfix = $countryCode
            ? "/" . strtoupper($countryCode)
            : "";
        try {
            $response = $this->client->request('GET', "price-list/{$tariffId}" . $countryPostfix);

            $body = $response->getBody();

            $responseObjects = json_decode($body, true);

            $rates = [];
            foreach ($responseObjects as $responseObject) {
                $rates[] = new RateInstance($responseObject);
            }

            return $rates;
        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }
}
