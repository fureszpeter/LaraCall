<?php

namespace LaraCall\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use Symfony\Component\Console\Helper\Table;

class EbayGetNeedFeedbackTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:feedback:list {--L|list-only : List only, do nothing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $transactions = $apiService->getShippedAndNoFeedbackTransactions();

        $disputes     = $apiService->getDisputes();
        $disputeArray = [];
        foreach ($disputes->DisputeArray->Dispute as $dispute) {
            dd($dispute);
            $disputeArray[$dispute->BuyerUserID] = [
                'date'    => $dispute->DisputeCreatedTime,
                'reason'  => $dispute->DisputeReason,
                'message' => $dispute->DisputeMessage,
            ];
        }

        dd($disputeArray);
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
                'Feedback',
                'Dispute',
            ]);

            foreach ($transactions->SoldList->OrderTransactionArray->OrderTransaction as $transaction) {
                if ( ! is_null($transaction->Transaction->FeedbackLeft)) {
                    continue;
                }

//                dd($transaction);

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
                        $transaction->Transaction->TotalPrice
                            ? $transaction->Transaction->TotalPrice->value
                            : '-',
                        $transaction->Transaction->TotalPrice
                            ? $transaction->Transaction->TotalPrice->currencyID
                            : ''
                    ),
                    $transaction->Transaction->ShippedTime instanceof DateTime
                        ? $transaction->Transaction->ShippedTime->format(DATE_ATOM)
                        : '-',
                    $transaction->Transaction->FeedbackReceived
                        ? $transaction->Transaction->FeedbackReceived->CommentText
                        : '-',
                    in_array($transaction->Transaction->Buyer->UserID, $disputeArray)
                        ? $disputeArray[$transaction->Transaction->Buyer->UserID]['reason']
                        : '-',
                ]);
            }

            $table->render();

            return;
        }
    }
}
