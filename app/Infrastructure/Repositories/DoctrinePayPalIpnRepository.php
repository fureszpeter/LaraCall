<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\PayPalIpnEntity;
use LaraCall\Domain\Repositories\PayPalIpnRepository;
use OutOfBoundsException;

class DoctrinePayPalIpnRepository extends EntityRepository implements PayPalIpnRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return PayPalIpnEntity
     */
    public function get(int $id): PayPalIpnEntity
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
     * @return PayPalIpnEntity
     */
    public function getOneBy(array $criteria): PayPalIpnEntity
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
        if (empty($orderBy))
        {
            $orderBy = [
                'id' => 'desc'
            ];
        }
        $builder      = $this->_em->createQueryBuilder();
        $queryBuilder = $builder
            ->addSelect(['ipn'])
            ->from(PayPalIpnEntity::class, 'ipn')
            ->setMaxResults($limit);
        foreach ($orderBy as $column => $order) {
            $queryBuilder->orderBy('ipn.' . $column, $order);
        }
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /**
     * @param PayPalIpnEntity $entity
     *
     * @return PayPalIpnEntity
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(PayPalIpnEntity $entity): PayPalIpnEntity
    {
        $this->_em->persist($entity);
        $this->_em->flush($entity);

        return $entity;
    }
}
