<?php

namespace LaraCall\Console\Commands;

use DateTime;
use DTS\eBaySDK\Trading\Enums\OrderStatusFilterCodeType;
use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use Symfony\Component\Console\Helper\Table;

class EbayGetSellerTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:sellerTransactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get transaction for the seller';

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
        $itemIdString = $this->option('itemId');

        $transactions = $apiService->getTransactions(OrderStatusFilterCodeType::C_ALL);

        $table = new Table($this->getOutput());
        $table->setHeaders([
            'Date',
            'PayedAt',
            'ItemId',
            'TransactionId',
            'Buyer',
            'Email',
            'Quantity',
            'Price',
            'Shipped',
        ]);

        foreach ($transactions->TransactionArray->Transaction as $transaction) {
            $table->addRow([
                $transaction->CreatedDate->format(DATE_ATOM),
                $transaction->PaidTime instanceof DateTime ? $transaction->PaidTime->format(DATE_ATOM) : '-',
                $itemIdString ?: $transaction->Item->ItemID,
                $transaction->TransactionID,
                $transaction->Buyer->UserID,
                $transaction->Buyer->Email,
                $transaction->QuantityPurchased,
                sprintf('%s %s', $transaction->AmountPaid->value, $transaction->AmountPaid->currencyID),
                $transaction->ShippedTime instanceof DateTime
                    ? $transaction->ShippedTime->format(DATE_ATOM)
                    : '-',
            ]);
        }

        $table->render();
    }
}
