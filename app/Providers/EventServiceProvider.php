<?php

namespace LaraCall\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaraCall\Events\DeliveryEntityCreatedEvent;
use LaraCall\Events\EbayPaymentCompleteEvent;
use LaraCall\Events\Handlers\SendDeliveryTokenEmail;
use LaraCall\Events\PaymentCompleteEvent;
use LaraCall\Events\PaymentFailedEvent;
use LaraCall\Events\PaymentHandlers\AddItemsToStockIfNeeded;
use LaraCall\Events\PaymentHandlers\DoEbayPostJobs;
use LaraCall\Events\PaymentHandlers\ProcessPayPalIpn;
use LaraCall\Events\PaymentHandlers\SendEbayPaymentReceivedNotification;
use LaraCall\Events\PaymentHandlers\SendPaymentReversedCanceledNotification;
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
        ],

        EbayPaymentCompleteEvent::class => [
            SendEbayPaymentReceivedNotification::class,
            DoEbayPostJobs::class,
            AddItemsToStockIfNeeded::class,
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
            SendPaymentReversedCanceledNotification::class,
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
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
