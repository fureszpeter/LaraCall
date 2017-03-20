<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\State;
use LaraCall\Domain\Repositories\StateRepository;
use OutOfBoundsException;

class DoctrineStateRepository extends EntityRepository implements StateRepository
{
    /**
     * @param string $stateCode
     *
     * @throws OutOfBoundsException
     *
     * @return State
     */
    public function get(string $stateCode): State
    {
        if ($entity = $this->find($stateCode)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('StateEntity not found by id. [id: %s]', $stateCode)
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
