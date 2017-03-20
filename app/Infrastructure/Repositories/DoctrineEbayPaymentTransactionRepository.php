<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\EbayPaymentTransaction;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use OutOfBoundsException;

class DoctrineEbayPaymentTransactionRepository extends EntityRepository implements EbayPaymentTransactionRepository
{
    /**
     * @param int $transactionId
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPaymentTransaction
     */
    public function get(int $transactionId): EbayPaymentTransaction
    {
        if ($entity = $this->find($transactionId)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('EbayPaymentTransaction not found by id. [id: %s]', $transactionId)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPaymentTransaction
     */
    public function getOneBy(array $criteria): EbayPaymentTransaction
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('EbayPaymentTransaction not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }

    /**
     * @param EbayPaymentTransaction $transaction
     *
     * @return EbayPaymentTransaction[]
     */
    public function getLastRefills(EbayPaymentTransaction $transaction)
    {
        return $this->findBy(['subscription' => $transaction->getSubscription()], ['datePayment' => 'DESC'], 10);
    }

    /**
     * @param EbayPaymentTransaction $transaction
     *
     * @return EbayPaymentTransaction
     */
    public function save(EbayPaymentTransaction $transaction): EbayPaymentTransaction
    {
        $this->_em->persist($transaction);
        $this->_em->flush($transaction);

        return $transaction;
    }
}
