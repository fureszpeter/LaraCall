<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\Delivery;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method Delivery find($id)
 * @method Delivery[] findAll()
 * @method Delivery[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Delivery findOneBy(array $criteria)
 */
interface DeliveryTokenRepository extends ObjectRepository
{
    /**
     * @param string $token
     *
     * @throws OutOfBoundsException
     *
     * @return Delivery
     */
    public function get(string $token): Delivery;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Delivery
     */
    public function getOneBy(array $criteria): Delivery;
}
