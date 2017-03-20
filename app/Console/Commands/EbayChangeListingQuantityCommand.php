<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use Symfony\Component\Console\Helper\Table;

class EbayChangeListingQuantityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:quantity'
    . ' {--I|item-id= : Item id}'
    . ' {--Q|quantity= : new quantity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change listing quantity.';

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
     */
    public function handle(EbayApiService $apiService)
    {
        $itemId   = new ItemId($this->option('item-id'));
        $quantity = $this->option('quantity');

        $response = $apiService->changeListingQuantity($itemId, $quantity);

        $table = new Table($this->getOutput());
        $table->setHeaders([
            'ItemId',
            'Name',
            'Fee',
            'Discount',
        ]);

        foreach ($response->Fees as $fees) {
            foreach ($fees->Fee as $fee) {
                $table->addRow([
                    $fees->ItemID,
                    $fee->Name,
                    $fee->Fee->value,
                    $fee->PromotionalDiscount ? $fee->PromotionalDiscount->value : 0,
                ]);
            }
        }

        $table->render();
    }
}
