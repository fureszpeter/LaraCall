<?php
namespace LaraCall\Events;

use LaraCall\Domain\ValueObjects\DeliveryToken;

class DeliveryEntityCreatedEvent extends Event
{
    /**
     * @var DeliveryToken
     */
    private $token;

    /**
     * @param DeliveryToken $token
     */
    public function __construct(DeliveryToken $token)
    {
        $this->token = $token;
    }

    /**
     * @return DeliveryToken
     */
    public function getToken(): DeliveryToken
    {
        return $this->token;
    }
}
