<?php

namespace LaraCall\Domain\Services;

use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Entities\Subscription;

interface EbayProcessPaymentService
{
    /**
     * @param Subscription $subscription
     * @param PayPalIpn    $ipn
     * @param bool|null    $newSubscription
     *
     * @return
     */
    public function addPaymentToSubscription(Subscription $subscription, PayPalIpn $ipn, bool $newSubscription = false);

    /**
     * @param PayPalIpn $ipn
     *
     * @return Subscription
     */
    public function createSubscriptionForIpn(PayPalIpn $ipn): Subscription;
}
