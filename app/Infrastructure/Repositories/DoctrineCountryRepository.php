<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use OutOfBoundsException;

class DoctrineCountryRepository extends EntityRepository implements CountryRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return Country
     */
    public function get(int $id): Country
    {
        if ($entity = $this->find($id)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('CountryEntity not found by id. [id: %s]', $id)
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
}
