<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\Country;
use LaraCall\Domain\Entities\Delivery;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Repositories\CountryRepository;
use LaraCall\Domain\Repositories\DeliveryTokenRepository;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use OutOfBoundsException;

class DoctrineDeliveryTokenRepository extends EntityRepository implements DeliveryTokenRepository
{
    /**
     * @param string $token
     *
     * @throws OutOfBoundsException
     *
     * @return Delivery
     */
    public function get(string $token): Delivery
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
     * @return Delivery
     */
    public function getOneBy(array $criteria): Delivery
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('DeliveryEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }
}
