<?php

namespace LaraCall\Domain\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\EbayPaymentTransaction;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method EbayPaymentTransaction find($transactionId)
 * @method EbayPaymentTransaction[] findAll()
 * @method EbayPaymentTransaction[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method EbayPaymentTransaction findOneBy(array $criteria)
 */
interface EbayPaymentTransactionRepository extends ObjectRepository
{
    /**
     * @param int $transactionId
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPaymentTransaction
     */
    public function get(int $transactionId): EbayPaymentTransaction;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPaymentTransaction
     */
    public function getOneBy(array $criteria): EbayPaymentTransaction;

    /**
     * @param EbayPaymentTransaction $transaction
     *
     * @return EbayPaymentTransaction[]
     */
    public function getLastRefills(EbayPaymentTransaction $transaction);

    /**
     * @param EbayPaymentTransaction $transaction
     *
     * @return EbayPaymentTransaction
     */
    public function save(EbayPaymentTransaction $transaction): EbayPaymentTransaction;
}
