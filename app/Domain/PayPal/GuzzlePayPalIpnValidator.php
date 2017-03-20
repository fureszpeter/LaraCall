<?php
namespace LaraCall\Domain\PayPal;

use GuzzleHttp\ClientInterface;
use LaraCall\Domain\PayPal\ValueObjects\PayPalIpn;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedPayPalIpn;

class GuzzlePayPalIpnValidator implements PayPalIpnValidator
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * @param ClientInterface $guzzleClient
     */
    public function __construct(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param PayPalIpn $saleMessage
     *
     * @return ValidatedPayPalIpn
     */
    public function validateIpn(PayPalIpn $saleMessage): ValidatedPayPalIpn
    {
        $url           = $saleMessage->isSandBox() ? self::VERIFY_URI_SANDBOX : self::VERIFY_URI;

        $rawPayPalData = $saleMessage->getRawPayPalData();
        $response      = $this->guzzleClient->request('POST', $url,
            [
                'form_params' => array_merge(
                    ['cmd' => '_notify-validate'],
                    $rawPayPalData
                ),
            ]
        );

        $contents = $response->getBody()->getContents();

        return new ValidatedPayPalIpn(
            $saleMessage->getRawPayPalData(),
            $contents == self::RESPONSE_VALID
        );
    }
}
