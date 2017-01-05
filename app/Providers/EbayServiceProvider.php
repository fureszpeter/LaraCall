<?php
namespace LaraCall\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\PayPal\GuzzlePayPalService;
use LaraCall\Domain\PayPal\PayPalServiceInterface;

/**
 * Class EbayServiceProvider
 *
 * @package LaraCall
 */
class EbayServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GuzzlePayPalService::class, function (){
            $payPal = new GuzzlePayPalService(new Client());

            return $payPal;
        });

        $this->app->bind(PayPalServiceInterface::class, GuzzlePayPalService::class);
    }
}
