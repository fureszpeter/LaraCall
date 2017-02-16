<?php

namespace LaraCall\Domain\PayPal;

use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedIpnSalesMessage;

interface PayPalIpnValidator
{
    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';

    /** Sandbox Postback URL */
    const VERIFY_URI_SANDBOX = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';


    const RESPONSE_VALID   = 'VERIFIED';
    const RESPONSE_INVALID = 'INVALID';

    /**
     * @param IpnSalesMessage $saleMessage
     *
     * @return ValidatedIpnSalesMessage
     */
    public function validateIpn(IpnSalesMessage $saleMessage): ValidatedIpnSalesMessage;
}
