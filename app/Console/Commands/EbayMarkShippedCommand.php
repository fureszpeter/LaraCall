<?php

namespace LaraCall\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use Symfony\Component\Console\Helper\Table;

class EbayMarkShippedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:markShipped'
    . ' {--F|force : Don\'t ask, just mark shipped}'
    . ' {--S|skip-filter= : Comma separated list of skipped ebay username}'
    . ' {--L|list-only : List only, do nothing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark ebay items as shipped';

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
        $force      = $this->option('force');
        $skipFilter = $this->option('skip-filter');

        $skippedEbayIds = $this->parseEbayUsernameFilter($skipFilter);

        $transactions = $apiService->getUnShippedTransactions();

        if ($this->option('list-only')) {
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

            foreach ($transactions->SoldList->OrderTransactionArray->OrderTransaction as $transaction) {
                if (in_array($transaction->Transaction->Buyer->UserID, $skippedEbayIds)) {
                    continue;
                }

                $table->addRow([
                    $transaction->Transaction->CreatedDate->format(DATE_ATOM),
                    $transaction->Transaction->PaidTime instanceof DateTime
                        ? $transaction->Transaction->PaidTime->format(DATE_ATOM) : '-',
                    $transaction->Transaction->Item->ItemID,
                    $transaction->Transaction->TransactionID,
                    $transaction->Transaction->Buyer->UserID,
                    $transaction->Transaction->Buyer->Email,
                    $transaction->Transaction->QuantityPurchased,
                    sprintf(
                        '%s %s',
                        $transaction->Transaction->TotalPrice->value,
                        $transaction->Transaction->TotalPrice->currencyID
                    ),
                    $transaction->Transaction->ShippedTime instanceof DateTime
                        ? $transaction->Transaction->ShippedTime->format(DATE_ATOM)
                        : '-',
                ]);
            }

            $table->render();

            return;
        }

        foreach ($transactions->SoldList->OrderTransactionArray->OrderTransaction as $transaction) {
            if (in_array($transaction->Transaction->Buyer->UserID, $skippedEbayIds)) {
                continue;
            }

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

            $table->addRow([
                $transaction->Transaction->CreatedDate->format(DATE_ATOM),
                $transaction->Transaction->PaidTime instanceof DateTime
                    ? $transaction->Transaction->PaidTime->format(DATE_ATOM) : '-',
                $transaction->Transaction->Item->ItemID,
                $transaction->Transaction->TransactionID,
                $transaction->Transaction->Buyer->UserID,
                $transaction->Transaction->Buyer->Email,
                $transaction->Transaction->QuantityPurchased,
                sprintf(
                    '%s %s',
                    $transaction->Transaction->TotalPrice->value,
                    $transaction->Transaction->TotalPrice->currencyID
                ),
                $transaction->Transaction->ShippedTime instanceof DateTime
                    ? $transaction->Transaction->ShippedTime->format(DATE_ATOM)
                    : '-',
            ]);

            $table->render();

            if ($force == true || $this->confirm('Mark item as shipped?', true)) {
                $apiService->markItemShipped(
                    $transaction->Transaction->Item->ItemID,
                    $transaction->Transaction->TransactionID
                );
            }
        }
    }

    /**
     * @param string|null $skipFilter
     *
     * @return string[]
     */
    private function parseEbayUsernameFilter(string $skipFilter = null): array
    {
        $ebayIds = [];

        if (is_null($skipFilter)) {
            return $ebayIds;
        }

        return array_map(function (string $username) {
            return trim($username);
        }, explode(',', $skipFilter));
    }
}
