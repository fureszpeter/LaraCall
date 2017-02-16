<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\PaymentTransaction;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Repositories\PaymentTransactionRepository;
use OutOfBoundsException;

class DoctrinePaymentTransactionRepository extends EntityRepository implements PaymentTransactionRepository
{
    /**
     * @param int $transactionId
     *
     * @throws OutOfBoundsException
     *
     * @return PaymentTransaction
     */
    public function get(int $transactionId): PaymentTransaction
    {
        if ($entity = $this->find($transactionId)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('PaymentTransaction not found by id. [id: %s]', $transactionId)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return PaymentTransaction
     */
    public function getOneBy(array $criteria): PaymentTransaction
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('PaymentTransaction not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }

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
    ) {
        $builder = $this->_em->createQueryBuilder();
        $builder->addSelect(['transaction'])
            ->from(PaymentTransaction::class, 'transaction')
            ->where($builder->expr()->in('transaction.pin', $subscription->getPins()->toArray()))
            ->setMaxResults($limit);
        foreach ($orderBy as $column => $order) {
            $builder->orderBy('transaction.' . $column, $order);
        }

        $query = $builder->getQuery();

        return $query->getResult();
    }
}
