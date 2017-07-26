<?php

namespace LaraCall\Events\PaymentHandlers;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Events\PayPalIpnEntityCreatedEvent;
use LaraCall\Jobs\ProcessPayPalIpnJob;

class ProcessPayPalIpn implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var PayPalIpnRepository
     */
    private $payPalIpnRepository;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @param PayPalIpnRepository $payPalIpnRepository
     * @param Dispatcher          $dispatcher
     */
    public function __construct(
        PayPalIpnRepository $payPalIpnRepository,
        Dispatcher $dispatcher
    ) {
        $this->payPalIpnRepository = $payPalIpnRepository;
        $this->dispatcher          = $dispatcher;
    }

    public function handle(PayPalIpnEntityCreatedEvent $event)
    {
        $this->dispatcher->dispatch(new ProcessPayPalIpnJob($event->getIpnId()));
    }
}
