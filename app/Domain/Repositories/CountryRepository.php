<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\Country;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method Country find($isoAlpha3)
 * @method Country[] findAll()
 * @method Country[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Country findOneBy(array $criteria)
 */
interface CountryRepository extends ObjectRepository
{
    /**
     * @param string $isoAlpha3
     *
     * @throws OutOfBoundsException
     *
     * @return Country
     */
    public function get(string $isoAlpha3): Country;

    public function getByIsoAlpha3(string $isoAlpha3): Country;

    public function getByIso2(string $iso2): Country;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Country
     */
    public function getOneBy(array $criteria): Country;
}
