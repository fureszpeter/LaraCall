<?php

namespace LaraCall\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaraCall\Events\DeliveryEntityCreatedEvent;
use LaraCall\Events\Handlers\SendDeliveryTokenEmail;
use LaraCall\Events\PaymentCompleteEvent;
use LaraCall\Events\PaymentFailedEvent;
use LaraCall\Events\PaymentHandlers\DoEbayPostJobs;
use LaraCall\Events\PaymentHandlers\ProcessPayPalIpn;
use LaraCall\Events\PaymentHandlers\SendPaymentReceivedNotification;
use LaraCall\Events\PaymentHandlers\SendPaymentReversedNotification;
use LaraCall\Events\PaymentPendingEvent;
use LaraCall\Events\PaymentRefundedEvent;
use LaraCall\Events\PaymentReversalCanceledEvent;
use LaraCall\Events\PaymentReversedEvent;
use LaraCall\Events\PayPalIpnEntityCreatedEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*
         * Event fired after a new TransactionLogEntity inserted into the database.
         */
        PayPalIpnEntityCreatedEvent::class => [
            ProcessPayPalIpn::class,
        ],

        PaymentCompleteEvent::class => [
            SendPaymentReceivedNotification::class,
            DoEbayPostJobs::class,
        ],

        DeliveryEntityCreatedEvent::class => [
            SendDeliveryTokenEmail::class,
        ],

        PaymentPendingEvent::class => [

        ],

        PaymentRefundedEvent::class => [

        ],

        PaymentReversedEvent::class => [
            SendPaymentReversedNotification::class,
        ],

        PaymentReversalCanceledEvent::class => [

        ],

        PaymentFailedEvent::class => [

        ],

    ];

    /**
     * Array of subscribers.
     *
     * @var array
     */
    protected $subscribe = [
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
