<?php
namespace LaraCall\Events;

class PayPalIpnEntityCreatedEvent extends Event
{
    /**
     * @var int
     */
    private $ipnId;

    /**
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
