<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use OutOfBoundsException;

class DoctrinePayPalIpnRepository extends EntityRepository implements PayPalIpnRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return PayPalIpn
     */
    public function get(int $id): PayPalIpn
    {
        if ($entity = $this->find($id)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('PayPalIpnEntity not found by id. [id: %s]', $id)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return PayPalIpn
     */
    public function getOneBy(array $criteria): PayPalIpn
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('PayPalIpnEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }

    /**
     * @param int   $limit
     * @param array $orderBy
     *
     * @return array
     */
    public function findLast(int $limit = 100, array $orderBy = []): array
    {
        $builder      = $this->_em->createQueryBuilder();
        $queryBuilder = $builder
            ->addSelect(['ipn'])
            ->from(PayPalIpn::class, 'ipn')
            ->setMaxResults($limit);
        foreach ($orderBy as $column => $order) {
            $queryBuilder->orderBy('ipn.' . $column, $order);
        }
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
