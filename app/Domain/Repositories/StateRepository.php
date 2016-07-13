<?php
namespace LaraCall\Domain\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\State;

interface StateRepository extends ObjectRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     *
     * @throws \OutOfBoundsException If not found.
     
     * @return State
     */
    public function getOneBy(array $criteria, array $orderBy = null);
}
