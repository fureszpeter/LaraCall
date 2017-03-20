<?php

namespace LaraCall\Events;

use LaraCall\Domain\PayPal\ValueObjects\PayPalIpn;
use Illuminate\Queue\SerializesModels;

class InvalidIpnMessageReceivedEvent extends Event
{
    use SerializesModels;

    /**
     * @var PayPalIpn
     */
    private $saleMessage;

    /**
     * Create a new event instance.
     *
     * @param PayPalIpn $saleMessage
     */
    public function __construct(PayPalIpn $saleMessage)
    {
        $this->saleMessage = $saleMessage;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
