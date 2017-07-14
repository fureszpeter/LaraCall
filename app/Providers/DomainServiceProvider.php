<?php

namespace LaraCall\Providers;

use A2bApiClient\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\Factories\PaymentStatusFactory;
use LaraCall\Domain\Services\ApiImportService;
use LaraCall\Domain\Services\EbayProcessPaymentService;
use LaraCall\Domain\Services\ImportService;
use LaraCall\Domain\Services\PasswordService;
use LaraCall\Domain\Services\PayPalIpnService;
use LaraCall\Domain\Services\PinGeneratorService;
use LaraCall\Infrastructure\Services\SimplePasswordService;
use LaraCall\Infrastructure\Services\SimplePinGeneratorService;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return new Client(
                env('A2B_API_BASE_URL'),
                env('A2B_API_USERNAME'),
                env('A2B_API_PASSWORD')
            );
        });

        $this->app->singleton(PayPalIpnService::class, function () {
            return new \LaraCall\Infrastructure\Services\PayPalIpnService(
                env('PAYPAL_SELLER_EMAIL'),
                app(PaymentStatusFactory::class)
            );
        });
        $this->app->singleton(ImportService::class, ApiImportService::class);
        $this->app->singleton(PinGeneratorService::class, SimplePinGeneratorService::class);
        $this->app->singleton(PasswordService::class, SimplePasswordService::class);
        $this->app->singleton(EbayProcessPaymentService::class,
            \LaraCall\Infrastructure\Services\EbayProcessPaymentService::class);
        $this->app->bind(ClientInterface::class, function(){
            return new \GuzzleHttp\Client();
        });
    }
}
