<?php

namespace LaraCall\Domain\Repositories;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\PaymentTransaction;
use LaraCall\Domain\Entities\Subscription;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method PaymentTransaction find($transactionId)
 * @method PaymentTransaction[] findAll()
 * @method PaymentTransaction[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method PaymentTransaction findOneBy(array $criteria)
 */
interface PaymentTransactionRepository extends ObjectRepository
{
    /**
     * @param int $transactionId
     *
     * @throws OutOfBoundsException
     *
     * @return PaymentTransaction
     */
    public function get(int $transactionId): PaymentTransaction;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return PaymentTransaction
     */
    public function getOneBy(array $criteria): PaymentTransaction;

    /**
     * @param Subscription $subscription
     * @param array        $orderBy
     * @param int          $limit
     *
     * @return ArrayCollection|PaymentTransaction[]
     */
    public function findBySubscription(
        Subscription $subscription,
        array $orderBy = ['createdAt' => 'DESC'],
        int $limit = 10
    );
}
