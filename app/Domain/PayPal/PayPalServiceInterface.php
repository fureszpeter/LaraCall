<?php

namespace LaraCall\Domain\PayPal;

use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;

interface PayPalServiceInterface
{
    /**
     * @param IpnSalesMessage $saleMessage
     *
     * @return bool
     */
    public function validateIpn(IpnSalesMessage $saleMessage): bool;
}
