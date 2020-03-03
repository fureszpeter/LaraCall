<?php

namespace LaraCall\Domain\PayPal;

interface PayPalIpnValidator
{
    const VERIFY_URI         = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    const VERIFY_URI_SANDBOX = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
    const RESPONSE_VALID     = 'VERIFIED';
    const RESPONSE_INVALID   = 'INVALID';

    public function isSentByPayPal(array $raw): bool;

    public function isSandbox(array $raw): bool;
}
