<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use Symfony\Component\Console\Helper\Table;

class EbayGetItemsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:getItems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get ebay for sale eBay items';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param EbayApiService $apiService
     *
     * @return mixed
     */
    public function handle(EbayApiService $apiService)
    {
        $items = $apiService->getForSaleItems();

        $table = new Table($this->getOutput());
        $table->setHeaders([
            'ItemId',
            'Title',
            'Price',
            'Quantity',
            'Url',
        ]);

        foreach ($items->ActiveList->ItemArray->Item as $item) {
            $table->addRow([
                $item->ItemID,
                $item->Title,
                sprintf('%s %s', $item->BuyItNowPrice->value, $item->BuyItNowPrice->currencyID),
                $item->QuantityAvailable,
                $item->ListingDetails->ViewItemURL,
            ]);
        }

        $table->render();
    }
}
