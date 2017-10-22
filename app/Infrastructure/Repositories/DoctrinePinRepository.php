<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\Pin;
use LaraCall\Domain\Repositories\PinRepository;
use OutOfBoundsException;

class DoctrinePinRepository extends EntityRepository implements PinRepository
{
    /**
     * @param string $pin
     *
     * @throws OutOfBoundsException
     *
     * @return Pin
     */
    public function get(string $pin): Pin
    {
        if ($entity = $this->find($pin)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('PinEntity not found by id. [id: %s]', $pin)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return Pin
     */
    public function getOneBy(array $criteria): Pin
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('PinEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }
}
