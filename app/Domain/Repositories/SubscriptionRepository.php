<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\Subscription;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method Subscription find($id)
 * @method Subscription[] findAll()
 * @method Subscription[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Subscription findOneBy(array $criteria)
 */
interface SubscriptionRepository extends ObjectRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return Subscription
     */
    public function get(int $id): Subscription;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Subscription
     */
    public function getOneBy(array $criteria): Subscription;
}
