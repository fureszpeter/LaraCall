<?php

namespace LaraCall\Events;

use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;
use LaraCall\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvalidIpnMessageReceivedEvent extends Event
{
    use SerializesModels;

    /**
     * @var IpnSalesMessage
     */
    private $saleMessage;

    /**
     * Create a new event instance.
     *
     * @param IpnSalesMessage $saleMessage
     */
    public function __construct(IpnSalesMessage $saleMessage)
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
