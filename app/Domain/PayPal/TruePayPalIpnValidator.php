<?php

namespace LaraCall\Domain\PayPal;

class TruePayPalIpnValidator implements PayPalIpnValidator
{
    public function isSentByPayPal(array $raw): bool
    {
        return true;
    }

    public function isSandbox(array $raw): bool
    {
        return false;
    }
}
