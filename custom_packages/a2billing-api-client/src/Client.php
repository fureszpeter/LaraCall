<?php
namespace A2bApiClient;

use A2bApiClient\Api\Payment;
use A2bApiClient\Api\PriceList;
use A2bApiClient\Api\Subscription;

class Client
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;


    /**
     * @param string $baseUrl
     * @param string $username
     * @param string $password
     */
    public function __construct($baseUrl, $username, $password)
    {
        $this->baseUrl  = $baseUrl;
        $this->username = $username;
        $this->password = $password;

        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'verify'   => false,
            'auth' => [
                $username,
                $password,
            ]
        ]);
    }

    /**
     * @return Subscription
     */
    public function getSubscription()
    {
        return new Subscription($this->httpClient);
    }

    /**
     * @param int $subscriptionId
     *
     * @return Payment
     */
    public function getPayment($subscriptionId)
    {
        return new Payment($this->httpClient, $subscriptionId);
    }

    public function getPriceList()
    {
        return new PriceList($this->httpClient);
    }
}
