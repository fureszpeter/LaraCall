<?php
namespace A2bApiClient\Api;

use A2bApiClient\Api\Instances\SubscriptionInstance;
use A2bApiClient\Exceptions\A2bApiException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

class Subscription
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
        $this->client          = $client;
    }

    /**
     * @param string $pin
     *
     * @return SubscriptionInstance
     *
     * @throws A2bApiException
     */
    public function getByPin($pin)
    {
        try {
            $response = $this->client->request('GET', "subscriptions", [
                'query' => [
                    'pin' => $pin,
                ],
            ]);

            $body = $response->getBody();

            return new SubscriptionInstance(json_decode($body, true));
        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }

    /**
     * @param int $id
     *
     * @return SubscriptionInstance
     *
     * @throws A2bApiException
     */
    public function getById($id)
    {
        try {
            $response = $this->client->request('GET', "subscriptions/{$id}");

            $body = $response->getBody();

            return new SubscriptionInstance(json_decode($body, true));
        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }

    /**
     * @param string $email
     *
     * @return SubscriptionInstance[]
     *
     * @throws A2bApiException
     */
    public function getByEmail($email)
    {
        try {
            $response = $this->client->request('GET', "subscriptions", [
                'query' => [
                    'email' => $email,
                ],
            ]);

            $body = $response->getBody();

            $responseObjects = json_decode($body, true);

            $subscriptions = [];
            foreach ($responseObjects as $responseObject) {
                $subscriptions[] = new SubscriptionInstance($responseObject);
            }

            return $subscriptions;
        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }

    /**
     * @param SubscriptionCreateRequest $createRequest
     *
     * @return int
     *
     * @throws A2bApiException
     */
    public function create(SubscriptionCreateRequest $createRequest)
    {
        try {
            $response = $this->client->request('POST', 'subscriptions',
                [
                    'json' => $createRequest,
                ]);

            $body = $response->getBody();

            return json_decode($body, true);

        } catch (ClientException $exception) {
            throw new A2bApiException($exception);
        }
    }
}
