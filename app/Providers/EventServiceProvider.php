<?php

namespace LaraCall\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaraCall\Events\TransactionLogCreatedEvent;
use LaraCall\Listeners\ProcessTransactionLogListener;

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
        TransactionLogCreatedEvent::class => [
            ProcessTransactionLogListener::class,
        ],

        'LaraCall\Events\SomeEvent' => [
            'LaraCall\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
