<?php
namespace A2bApiClient\Api;

use A2bApiClient\Api\Instances\PaymentInstance;
use A2bApiClient\Exceptions\A2bApiException;
use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Payment
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var int
     */
    private $subscriptionId;

    /**
     * @param Client $client
     * @param int    $subscriptionId
     */
    public function __construct(Client $client, $subscriptionId)
    {
        $this->client         = $client;
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @return PaymentInstance[]
     *
     * @throws A2bApiException
     */
    public function list()
    {
        try {
            $response = $this->client->request('GET', "subscriptions/{$this->subscriptionId}/payments");

            $body = $response->getBody();

            $responseObjects = json_decode($body, true);

            $subscriptions = [];
            foreach ($responseObjects as $responseObject) {
                $subscriptions[] = new PaymentInstance($responseObject);
            }

            return $subscriptions;
        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }

    /**
     * @param float             $credit
     * @param float             $amount
     * @param int               $quantity
     * @param string            $method
     * @param DateTimeInterface $dateOfPurchase
     *
     * @return int
     * @throws A2bApiException
     */
    public function create(
        float $credit,
        float $amount,
        int $quantity,
        string $method,
        DateTimeInterface $dateOfPurchase = null
    ) {
        $requestArray = [
            'creditValue' => $credit,
            'payedAmount' => $amount,
            'quantity'    => $quantity,
            'method'      => $method,
        ];

        if ($dateOfPurchase) {
            $requestArray['dateOfPurchase'] = $dateOfPurchase->format(DATE_ATOM);
        }

        try {
            $response = $this->client->request(
                'POST',
                "subscriptions/{$this->subscriptionId}/payments",
                [
                    'json' => $requestArray,
                ]
            );

            $body = $response->getBody();

            $paymentId = json_decode($body, true);

            return $paymentId;
        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }
}
