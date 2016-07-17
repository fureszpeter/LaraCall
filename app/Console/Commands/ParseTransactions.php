<?php
namespace LaraCall\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LaraCall\Domain\Entities\EbayTransactionLog;
use LaraCall\Domain\ValueObjects\OrderStatusVO;
use LaraCall\Jobs\ProcessTransactionJob;

/**
 * Class GetItemTransactionsCommand.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class ParseTransactions extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:transactions:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-parse transactions.';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Create a new command instance.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $repository   = $this->em->getRepository(EbayTransactionLog::class);
        /** @var EbayTransactionLog[] $transactions */
        $transactions = $repository->findBy(['orderStatus' => OrderStatusVO::STATUS_PROCESSING]);

        foreach ($transactions as $transaction) {
            $this->info('Dispatching job. ' . $transaction->getTransactionId());
            $this->dispatch(new ProcessTransactionJob($transaction));
        }
    }
}
