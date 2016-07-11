<?php
namespace LaraCall\Providers;

use Config;
use DTS\eBaySDK\Constants\SiteIds;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(TradingService::class, function (){

            $service = new TradingService([
                'credentials' => Config::get("ebay.credentials", []),
                'sandbox'     => Config::get("ebay.sandbox"),
                'siteId'      => SiteIds::US
            ]);

            return $service;
        });

        $this->app->bind(CustomSecurityHeaderType::class, function(){
            $securityHeader = new CustomSecurityHeaderType();
            $securityHeader->eBayAuthToken = Config::get('ebay.authToken');

            return $securityHeader;
        });
    }
}
