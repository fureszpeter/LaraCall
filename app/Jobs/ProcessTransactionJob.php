<?php
namespace LaraCall\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use LaraCall\Domain\Entities\EbayTransactionLog;
use LaraCall\Domain\ValueObjects\OrderStatusVO;

/**
 * Class ProcessTransactionJob.
 *
 * @package LaraCall\Jobs
 */
class ProcessTransactionJob
{
    /**
     * @var EbayTransactionLog
     */
    private $transactionLog;

    /**
     * @param EbayTransactionLog $transactionLog
     */
    public function __construct(EbayTransactionLog $transactionLog)
    {
        $this->transactionLog = $transactionLog;
    }

    /**
     * @param EntityManagerInterface $em
     */
    public function handle(EntityManagerInterface $em)
    {
        $em->transactional(function ($em) {
            $status = OrderStatusVO::STATUS_PROCESSING();
            $this->transactionLog->setOrderStatus($status);
            
            

        });

        echo 'handling transaction: ' . $this->transactionLog->getOrderStatus();
    }
}
