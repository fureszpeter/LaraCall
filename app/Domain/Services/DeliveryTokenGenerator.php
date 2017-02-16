<?php

namespace LaraCall\Domain\Services;

use LaraCall\Domain\ValueObjects\DeliveryToken;

interface DeliveryTokenGenerator
{
    /**
     * @return DeliveryToken
     */
    public function generate(): DeliveryToken;
}
