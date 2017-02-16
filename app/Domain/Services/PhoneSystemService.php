<?php

namespace LaraCall\Domain\Services;

use LaraCall\Domain\Entities\User;

interface PhoneSystemService
{
    /**
     * @param string $subscription
     * @param string $amount
     * @param string $currency
     *
     * @return mixed
     */
    public function refill(string $subscription, string $amount, string $currency);

    public function register(User $userEntity);
}
