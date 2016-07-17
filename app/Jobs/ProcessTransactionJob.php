<?php
namespace LaraCall\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use LaraCall\Domain\Entities\EbayTransactionLog;
use LaraCall\Domain\Services\TransactionDataParser;
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
     * @param TransactionDataParser  $dataParser
     */
    public function handle(EntityManagerInterface $em, TransactionDataParser $dataParser)
    {
        $this->transactionLog->setOrderStatus(OrderStatusVO::STATUS_PROCESSING());
        $em->persist($this->transactionLog);
        $em->flush($this->transactionLog);

        $em->beginTransaction();

            $jsonData = json_decode($this->transactionLog->getTransactionData());
            $result = $dataParser->parse($jsonData);

            $this->transactionLog->setOrderStatus($result->getOrderStatusVO());
            $this->transactionLog->setItemId($result->getItemId());
            $this->transactionLog->setQuantity($result->getQuantity());
            $this->transactionLog->setAmountPayed($result->getAmountPayed());
            $this->transactionLog->setSoldPricePerItem($result->getSoldPricePerItem());

            $em->flush($this->transactionLog);

        $em->commit();

        echo 'handling transaction: ' . $this->transactionLog->getOrderStatus();
    }
}
