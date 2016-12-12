<?php
namespace LaraCall\Console\Commands;

use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetMyeBaySellingRequestType;
use DTS\eBaySDK\Trading\Types\ItemListCustomizationType;
use Illuminate\Console\Command;
use LaraCall\Domain\Entities\Item;
use LaraCall\Domain\ValueObjects\eBay\EbayItemIdVO;
use LaraCall\Domain\ValueObjects\EbayConfig;
use RuntimeException;

/**
 * Class FetchItems.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class FetchItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:fetch:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Ebay items';

    /**
     * @var TradingService
     */
    private $tradingService;

    /**
     * @var CustomSecurityHeaderType
     */
    private $customSecurityHeaderType;

    /**
     * @var EbayConfig
     */
    private $ebayConfig;

    /**
     * @param TradingService           $tradingService
     * @param CustomSecurityHeaderType $customSecurityHeaderType
     * @param EbayConfig               $ebayConfig
     */
    public function __construct(
        TradingService $tradingService,
        CustomSecurityHeaderType $customSecurityHeaderType,
        EbayConfig $ebayConfig
    )
    {
        parent::__construct();
        $this->tradingService = $tradingService;
        $this->customSecurityHeaderType = $customSecurityHeaderType;
        $this->ebayConfig = $ebayConfig;
    }

    public function handle()
    {
        $this->info('Fetching items.');

        $request = new GetMyeBaySellingRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $include = (new ItemListCustomizationType());
        $include->Include = true;
        $request->ActiveList = $include;

        $response = $this->tradingService->getMyeBaySelling($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                $this->error($error->LongMessage);
                throw new RuntimeException($error->LongMessage);
            }
        }

        foreach ($response->ActiveList->ItemArray->Item as $item) {
            $this->info(var_export($item->toArray(), true));
            $itemEntity = new Item(
                new EbayItemIdVO($item->ItemID),
                $item->Title,
                floatval($item->BuyItNowPrice->value),
                $this->ebayConfig->getSellerUserName(),
                false
            );

            $this->info(json_encode($itemEntity));
        }

    }
}
