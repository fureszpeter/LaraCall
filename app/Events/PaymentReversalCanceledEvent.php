<?php

namespace LaraCall\Events;

use Illuminate\Queue\SerializesModels;

class PaymentReversalCanceledEvent extends Event
{
    use SerializesModels;

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
