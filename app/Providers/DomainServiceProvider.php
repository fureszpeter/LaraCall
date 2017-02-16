<?php

namespace LaraCall\Providers;

use A2bApiClient\Client;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\Factories\PaymentStatusFactory;
use LaraCall\Domain\PayPal\NativePayPalService;
use LaraCall\Domain\Services\DeliveryTokenGenerator;
use LaraCall\Domain\Services\EbayUsernameTokenResolver;
use LaraCall\Domain\Services\PasswordService;
use LaraCall\Domain\Services\PaymentProcessorInterface;
use LaraCall\Domain\Services\PayPalIpnAddressResolver;
use LaraCall\Domain\Services\PayPalIpnService;
use LaraCall\Domain\Services\PinGeneratorService;
use LaraCall\Infrastructure\Services\DbEbayUsernameTokenResolver;
use LaraCall\Infrastructure\Services\PayPalIpnPaymentProcessorInterface;
use LaraCall\Infrastructure\Services\SimplePasswordService;
use LaraCall\Infrastructure\Services\SimplePinGeneratorService;
use LaraCall\Infrastructure\Services\SimpleTokenGenerator;
use LaraCall\Jobs\ProcessPayPalIpnJob;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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

        $this->app->singleton(EbayUsernameTokenResolver::class, DbEbayUsernameTokenResolver::class);
        $this->app->singleton(PayPalIpnAddressResolver::class, \LaraCall\Infrastructure\Services\PayPalIpnAddressResolver::class);
        $this->app->singleton(DeliveryTokenGenerator::class, SimpleTokenGenerator::class);

        $this->app->singleton(PayPalIpnService::class, function(){
            return new \LaraCall\Infrastructure\Services\PayPalIpnService(
                env('PAYPAL_SELLER_EMAIL'),
                app(PaymentStatusFactory::class)
            );
        });
        $this->app->singleton(PinGeneratorService::class, SimplePinGeneratorService::class);
        $this->app->singleton(PasswordService::class, SimplePasswordService::class);
        $this->app
            ->when(ProcessPayPalIpnJob::class)
            ->needs(PaymentProcessorInterface::class)
            ->give(PayPalIpnPaymentProcessorInterface::class);
    }
}
