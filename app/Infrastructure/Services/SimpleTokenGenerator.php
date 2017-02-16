<?php
namespace LaraCall\Infrastructure\Services;

use Illuminate\Support\Str;
use LaraCall\Domain\Services\DeliveryTokenGenerator;
use LaraCall\Domain\ValueObjects\DeliveryToken;

class SimpleTokenGenerator implements DeliveryTokenGenerator
{

    /**
     * @return DeliveryToken
     */
    public function generate(): DeliveryToken
    {
        return new DeliveryToken(Str::random(25));
    }
}
