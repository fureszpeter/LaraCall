<?php

namespace LaraCall\Domain\PayPal;

use LaraCall\Domain\PayPal\ValueObjects\PayPalIpn;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedPayPalIpn;

interface PayPalIpnValidator
{
    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';

    /** Sandbox Postback URL */
    const VERIFY_URI_SANDBOX = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';


    const RESPONSE_VALID   = 'VERIFIED';
    const RESPONSE_INVALID = 'INVALID';

    /**
     * @param PayPalIpn $saleMessage
     *
     * @return ValidatedPayPalIpn
     */
    public function validateIpn(PayPalIpn $saleMessage): ValidatedPayPalIpn;
}
