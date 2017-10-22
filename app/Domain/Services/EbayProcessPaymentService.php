<?php

namespace LaraCall\Domain\Services;

use LaraCall\Domain\Entities\PayPalIpnEntity;
use LaraCall\Domain\Entities\Subscription;

interface EbayProcessPaymentService
{
    /**
     * @param Subscription    $subscription
     * @param PayPalIpnEntity $ipn
     * @param bool            $newSubscription
     *
     * @return
     */
    public function addPaymentToSubscription(Subscription $subscription, PayPalIpnEntity $ipn, bool $newSubscription = false);

    /**
     * @param PayPalIpnEntity $ipn
     *
     * @return Subscription
     */
    public function createSubscriptionForIpn(PayPalIpnEntity $ipn): Subscription;
}
