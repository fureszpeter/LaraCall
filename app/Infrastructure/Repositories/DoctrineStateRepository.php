<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Entities\State;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use LaraCall\Domain\Repositories\StateRepository;
use OutOfBoundsException;

class DoctrineStateRepository extends EntityRepository implements StateRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return State
     */
    public function get(int $id): State
    {
        if ($entity = $this->find($id)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('StateEntity not found by id. [id: %s]', $id)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return State
     */
    public function getOneBy(array $criteria): State
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('StateEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }
}
