<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\Country;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method Country find($id)
 * @method Country[] findAll()
 * @method Country[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Country findOneBy(array $criteria)
 */
interface CountryRepository extends ObjectRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return Country
     */
    public function get(int $id): Country;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Country
     */
    public function getOneBy(array $criteria): Country;
}
