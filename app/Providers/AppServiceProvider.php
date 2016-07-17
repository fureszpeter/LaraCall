<?php

namespace LaraCall\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\Services\EbayTransactionDataParser;
use LaraCall\Domain\Services\TransactionDataParser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         /*
         * Non-production service providers.
         */
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->singleton(TransactionDataParser::class, EbayTransactionDataParser::class);
    }
}
