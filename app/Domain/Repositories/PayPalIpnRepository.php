<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\PayPalIpnEntity;
use OutOfBoundsException;

/**
 * @method PayPalIpnEntity find($id)
 * @method PayPalIpnEntity[] findAll()
 * @method PayPalIpnEntity[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method PayPalIpnEntity findOneBy(array $criteria)
 */
interface PayPalIpnRepository extends ObjectRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return PayPalIpnEntity
     */
    public function get(int $id) : PayPalIpnEntity;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return PayPalIpnEntity
     */
    public function getOneBy(array $criteria) : PayPalIpnEntity;

    /**
     * @param int   $limit
     * @param array $orderBy
     *
     * @return PayPalIpnEntity[]
     */
    public function findLast(int $limit, array $orderBy = []) : array;

    /**
     * @param PayPalIpnEntity $entity
     *
     * @return PayPalIpnEntity
     */
    public function save(PayPalIpnEntity $entity): PayPalIpnEntity;
}
