<?php
namespace LaraCall\Providers;

use DTS\eBaySDK\Constants\SiteIds;
use DTS\eBaySDK\Shopping\Services\ShoppingService;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\PayPal\PayPalIpnValidator;
use LaraCall\Factories\PayPalIpnValidatorFactory;
use LaraCall\Infrastructure\Services\Ebay\EbayConfig;

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
        $this->app->singleton(PayPalIpnValidator::class, function () {
            return app()->make(PayPalIpnValidatorFactory::class)->make();
        });

        $this->app->singleton(EbayConfig::class, function () {
            $ebayConfig = [
                'sandbox'     => env('EBAY_SANDBOX'),
                'credentials' => [
                    'devId'  => env('EBAY_DEV_ID'),
                    'appId'  => env('EBAY_APP_ID'),
                    'certId' => env('EBAY_CERT_ID'),
                ],
                'authToken'   => env('EBAY_AUTH_TOKEN'),
                'sellerUser'  => env('EBAY_SELLER_USER'),
            ];

            return new EbayConfig(
                $ebayConfig["sandbox"],
                $ebayConfig["credentials"]["devId"],
                $ebayConfig["credentials"]["appId"],
                $ebayConfig["credentials"]["certId"],
                $ebayConfig["authToken"],
                $ebayConfig["sellerUser"]
            );
        });

        $this->app->bind(CustomSecurityHeaderType::class, function () {
            /** @var EbayConfig $config */
            $config = app()->make(EbayConfig::class);

            $securityHeader                = new CustomSecurityHeaderType();
            $securityHeader->eBayAuthToken = $config->getAuthToken();

            return $securityHeader;
        });

        $this->app->singleton(TradingService::class, function () {
            /** @var EbayConfig $config */
            $config = app()->make(EbayConfig::class);

            $service = new TradingService([
                'credentials' => $config->getCredentials(),
                'sandbox'     => $config->getIsSandbox(),
                'siteId'      => SiteIds::US,
            ]);

            return $service;
        });

        $this->app->singleton(ShoppingService::class, function () {
            /** @var EbayConfig $config */
            $config = app()->make(EbayConfig::class);

            $service = new ShoppingService([
                'credentials' => $config->getCredentials(),
                'sandbox'     => $config->getIsSandbox(),
                'siteId'      => SiteIds::US,
            ]);

            return $service;
        });
    }
}
