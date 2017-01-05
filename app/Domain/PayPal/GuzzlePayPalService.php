<?php
namespace LaraCall\Domain\PayPal;

use GuzzleHttp\ClientInterface;
use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;

class GuzzlePayPalService implements PayPalServiceInterface
{
    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';

    /** Sandbox Postback URL */
    const VERIFY_URI_SANDBOX = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

    const RESPONSE_VALID   = 'VERIFIED';
    const RESPONSE_INVALID = 'INVALID';

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
     * @param IpnSalesMessage $saleMessage
     *
     * @return bool
     */
    public function validateIpn(IpnSalesMessage $saleMessage): bool
    {
        $url = $saleMessage->isSandBox() ? self::VERIFY_URI_SANDBOX : self::VERIFY_URI;

        $response = $this->guzzleClient->request('POST', $url,
            [
                'form_params' => array_merge(
                    ['cmd' => '_notify-validate'],
                    $saleMessage->getRawPayPalData()
                ),
            ]
        );

        return $response->getBody()->getContents() == self::RESPONSE_VALID;
    }
}
