<?php

namespace LaraCall\Domain\Services;

use LaraCall\Domain\ValueObjects\BillingInfo;

interface PayPalIpnAddressResolver
{
    /**
     * @param array $ipn
     *
     * @return BillingInfo
     */
    public function resolve(array $ipn): BillingInfo;
}
