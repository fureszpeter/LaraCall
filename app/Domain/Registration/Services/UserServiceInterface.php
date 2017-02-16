<?php

namespace LaraCall\Domain\Registration\Services;

use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\ValueObjects\BillingInfo;
use LaraCall\Domain\ValueObjects\BuyerInfo;
use LaraCall\Domain\ValueObjects\ShippingInfo;

/**
 * Interface UserServiceInterface
 * @package LaraCall\Domain\Services
 */
interface UserServiceInterface
{
    /**
     * @param BuyerInfo    $buyerInfo
     * @param BillingInfo  $billingInfo
     * @param ShippingInfo $shippingInfo
     *
     * @return Subscription
     *
     */
    public function register(
        BuyerInfo $buyerInfo,
        BillingInfo $billingInfo,
        ShippingInfo $shippingInfo
    ): Subscription;
}
