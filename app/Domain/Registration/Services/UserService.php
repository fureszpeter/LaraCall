<?php
namespace LaraCall\Domain\Registration\Services;

use LaraCall\Domain\ValueObjects\BillingInfo;
use LaraCall\Domain\ValueObjects\BuyerInfo;
use LaraCall\Domain\ValueObjects\ShippingInfo;

class UserService implements UserServiceInterface
{
    /**
     * @param BuyerInfo    $buyerInfo
     * @param BillingInfo  $billingInfo
     * @param ShippingInfo $shippingInfo
     *
     * @return string
     * @internal param string $email
     *
     */
    public function register(BuyerInfo $buyerInfo, BillingInfo $billingInfo, ShippingInfo $shippingInfo): string
    {
        // TODO: Implement register() method.
    }
}
