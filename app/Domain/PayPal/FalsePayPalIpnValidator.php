<?php
namespace LaraCall\Domain\PayPal;

use LaraCall\Domain\PayPal\ValueObjects\PayPalIpn;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedPayPalIpn;

class FalsePayPalIpnValidator implements PayPalIpnValidator
{
    /**
     * @param PayPalIpn $saleMessage
     *
     * @return ValidatedPayPalIpn
     */
    public function validateIpn(PayPalIpn $saleMessage): ValidatedPayPalIpn
    {
        return new ValidatedPayPalIpn(
            $saleMessage->getRawPayPalData(),
            false
        );
    }
}
