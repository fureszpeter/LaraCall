<?php

namespace LaraCall\Domain\PayPal;

use GuzzleHttp\ClientInterface;

class GuzzlePayPalIpnValidator implements PayPalIpnValidator
{
    /** @var ClientInterface */
    private $guzzleClient;

    /**
     * @param ClientInterface $guzzleClient
     */
    public function __construct(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param array $raw
     *
     * @return bool
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isSentByPayPal(array $raw): bool
    {
        $url = $this->isSandBox($raw) ? self::VERIFY_URI_SANDBOX : self::VERIFY_URI;

        $response = $this->guzzleClient->request('POST', $url,
            [
                'form_params' => array_merge(
                    ['cmd' => '_notify-validate'],
                    $raw
                ),
            ]
        );

        $contents = $response->getBody()->getContents();

        return $contents == self::RESPONSE_VALID;
    }

    /**
     * @param array $raw
     *
     * @return bool
     */
    public function isSandbox(array $raw): bool
    {
        return
            array_key_exists('test_ipn', $raw)
            && $raw['test_ipn'] == 1;
    }
}
