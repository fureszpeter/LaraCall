<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\PinTokenDelivery;
use LaraCall\Domain\Repositories\DeliveryTokenRepository;
use OutOfBoundsException;

class DoctrineDeliveryTokenRepository extends EntityRepository implements DeliveryTokenRepository
{
    /**
     * @param string $token
     *
     * @throws OutOfBoundsException
     *
     * @return PinTokenDelivery
     */
    public function get(string $token): PinTokenDelivery
    {
        if ($entity = $this->find($token)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('DeliveryEntity not found by id. [id: %s]', $token)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return PinTokenDelivery
     */
    public function getOneBy(array $criteria): PinTokenDelivery
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('DeliveryEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }
}
