<?php
namespace LaraCall\Providers;

use Config;
use DTS\eBaySDK\Constants\SiteIds;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use Illuminate\Support\ServiceProvider;
use LaraCall\Domain\Services\EbaySyncService;
use LaraCall\Domain\Services\SyncService;
use LaraCall\Domain\ValueObjects\EbayConfig;

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
        $this->app->singleton(EbayConfig::class, function (){

            return new EbayConfig(
                Config::get("ebay.sandbox"),
                Config::get("ebay.credentials.devId"),
                Config::get("ebay.credentials.appId"),
                Config::get("ebay.credentials.certId"),
                Config::get("ebay.authToken"),
                Config::get("ebay.sellerUser")
            );
        });

        $this->app->singleton(TradingService::class, function (){
            /** @var EbayConfig $config */
            $config = $this->app->make(EbayConfig::class);

            $service = new TradingService([
                'credentials' => $config->getCredentials(),
                'sandbox'     => $config->getIsSandbox(),
                'siteId'      => SiteIds::US
            ]);

            return $service;
        });

        $this->app->bind(CustomSecurityHeaderType::class, function(){
            /** @var EbayConfig $config */
            $config = $this->app->make(EbayConfig::class);

            $securityHeader = new CustomSecurityHeaderType();
            $securityHeader->eBayAuthToken = $config->getAuthToken();

            return $securityHeader;
        });

        $this->app->bind(SyncService::class, EbaySyncService::class);
    }
}
