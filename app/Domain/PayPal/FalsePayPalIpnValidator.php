<?php

namespace LaraCall\Domain\PayPal;

class FalsePayPalIpnValidator implements PayPalIpnValidator
{
    public function isSentByPayPal(array $raw): bool
    {
        return false;
    }

    public function isSandbox(array $raw): bool
    {
        return false;
    }
}
