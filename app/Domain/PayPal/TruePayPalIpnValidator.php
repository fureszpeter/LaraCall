<?php
namespace LaraCall\Domain\PayPal;

use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedIpnSalesMessage;

class TruePayPalIpnValidator implements PayPalIpnValidator
{
    /**
     * @param IpnSalesMessage $saleMessage
     *
     * @return ValidatedIpnSalesMessage
     */
    public function validateIpn(IpnSalesMessage $saleMessage): ValidatedIpnSalesMessage
    {
        return new ValidatedIpnSalesMessage(
            $saleMessage->getRawPayPalData(),
            true
        );
    }
}
