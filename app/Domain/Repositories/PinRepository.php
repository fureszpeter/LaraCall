<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\Pin;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method Pin find($pin)
 * @method Pin[] findAll()
 * @method Pin[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Pin findOneBy(array $criteria)
 */
interface PinRepository extends ObjectRepository
{
    /**
     * @param string $pin
     *
     * @throws OutOfBoundsException
     *
     * @return Pin
     */
    public function get(string $pin): Pin;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Pin
     */
    public function getOneBy(array $criteria): Pin;
}
