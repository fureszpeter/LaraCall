<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Repositories\CountryRepository;
use OutOfBoundsException;

class DoctrineCountryRepository extends EntityRepository implements CountryRepository
{
    /**
     * @param string $isoAlpha3
     *
     * @throws OutOfBoundsException
     *
     * @return Country
     */
    public function get(string $isoAlpha3): Country
    {
        if ($entity = $this->find($isoAlpha3)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('CountryEntity not found by code. [code: %s]', $isoAlpha3)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Country
     */
    public function getOneBy(array $criteria): Country
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('CountryEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }

    public function getByIsoAlpha3(string $isoAlpha3): Country
    {
        return $this->get($isoAlpha3);
    }

    public function getByIso2(string $iso2): Country
    {
        if ($entity = $this->findOneBy(['countryCode' => $iso2])) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('CountryEntity not found by code. [code: %s]', $iso2)
        );
    }
}
