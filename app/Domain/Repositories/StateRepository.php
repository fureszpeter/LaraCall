<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\State;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method State find($id)
 * @method State[] findAll()
 * @method State[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method State|null findOneBy(array $criteria)
 */
interface StateRepository extends ObjectRepository
{
    /**
     * @param string $stateCode
     *
     * @return State
     */
    public function get(string $stateCode): State;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return State
     */
    public function getOneBy(array $criteria): State;
}
