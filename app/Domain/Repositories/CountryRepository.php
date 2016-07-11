<?php

namespace LaraCall\Domain\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\Country;

interface CountryRepository extends ObjectRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     *
     * @throws \OutOfBoundsException If not found.

     * @return Country
     */
    public function getOneBy(array $criteria, array $orderBy = null);
}
