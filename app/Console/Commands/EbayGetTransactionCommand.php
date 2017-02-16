<?php

namespace LaraCall\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use Symfony\Component\Console\Helper\Table;

class EbayGetTransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:transaction {itemId : ItemId what the transaction belongs to} {transactionId : Transaction Id}';

    /**
     * The console command description.
     */
    protected $description = 'Return the detailed transaction';

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
     * @param EbayApiService $service
     *
     * @return mixed
     */
    public function handle(EbayApiService $service)
    {
        $itemId        = new ItemId($this->argument('itemId'));
        $transactionId = $this->argument('transactionId');

        $transaction = $service->getTransaction($itemId, $transactionId);

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
            'Address',
        ]);

        $table->addRow([
            $transaction->CreatedDate->format(DATE_ATOM),
            $transaction->PaidTime instanceof DateTime ? $transaction->PaidTime->format(DATE_ATOM) : '-',
            $itemId,
            $transaction->TransactionID,
            $transaction->Buyer->UserID,
            $transaction->Buyer->Email,
            $transaction->QuantityPurchased,
            sprintf('%s %s', $transaction->ConvertedAmountPaid->value, $transaction->AmountPaid->currencyID),
            $transaction->ShippedTime instanceof DateTime
                ? $transaction->ShippedTime->format(DATE_ATOM)
                : '-',
            (
                $transaction->Buyer->BuyerInfo->ShippingAddress->Country
                . ', ' . ($transaction->Buyer->BuyerInfo->ShippingAddress->StateOrProvince ?: '-')
                . ', ' . $transaction->Buyer->BuyerInfo->ShippingAddress->PostalCode
                . ', ' . $transaction->Buyer->BuyerInfo->ShippingAddress->CityName
                . ', ' . $transaction->Buyer->BuyerInfo->ShippingAddress->Street1
            ),
        ]);

        $table->render();
    }
}
