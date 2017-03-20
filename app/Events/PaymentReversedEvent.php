<?php

namespace LaraCall\Events;


class PaymentReversedEvent extends Event
{
    /**
     * @var int
     */
    private $ipnId;

    /**
     * Create a new event instance.
     *
     * @param int $ipnId
     */
    public function __construct(int $ipnId)
    {
        $this->ipnId = $ipnId;
    }

    /**
     * @return int
     */
    public function getIpnId(): int
    {
        return $this->ipnId;
    }
}
