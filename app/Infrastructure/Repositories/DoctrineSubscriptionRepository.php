<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Repositories\SubscriptionRepository;
use OutOfBoundsException;

class DoctrineSubscriptionRepository extends EntityRepository implements SubscriptionRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return Subscription
     */
    public function get(int $id): Subscription
    {
        if ($entity = $this->find($id)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('SubscriptionEntity not found by id. [id: %s]', $id)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Subscription
     */
    public function getOneBy(array $criteria): Subscription
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('SubscriptionEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }
}
