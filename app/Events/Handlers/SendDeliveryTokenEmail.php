<?php
namespace LaraCall\Events\Handlers;

use Illuminate\Contracts\Queue\ShouldQueue;
use LaraCall\Events\DeliveryEntityCreatedEvent;

class SendDeliveryTokenEmail implements ShouldQueue
{
    /**
     * @param DeliveryEntityCreatedEvent $event
     */
    public function handle(DeliveryEntityCreatedEvent $event)
    {
        echo sprintf('sending token. [token: %s]', $event->getToken());
    }
}
