<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\PayPalIpn;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method PayPalIpn find($id)
 * @method PayPalIpn[] findAll()
 * @method PayPalIpn[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method PayPalIpn findOneBy(array $criteria)
 */
interface PayPalIpnRepository extends ObjectRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return PayPalIpn
     */
    public function get(int $id) : PayPalIpn;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return PayPalIpn
     */
    public function getOneBy(array $criteria) : PayPalIpn;

    /**
     * @param int   $limit
     * @param array $orderBy
     *
     * @return PayPalIpn[]
     */
    public function findLast(int $limit, array $orderBy = []) : array;
}
