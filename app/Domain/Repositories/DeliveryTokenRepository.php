<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\PinTokenDelivery;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method PinTokenDelivery find($id)
 * @method PinTokenDelivery[] findAll()
 * @method PinTokenDelivery[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method PinTokenDelivery findOneBy(array $criteria)
 */
interface DeliveryTokenRepository extends ObjectRepository
{
    /**
     * @param string $token
     *
     * @throws OutOfBoundsException
     *
     * @return PinTokenDelivery
     */
    public function get(string $token): PinTokenDelivery;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return PinTokenDelivery
     */
    public function getOneBy(array $criteria): PinTokenDelivery;
}
