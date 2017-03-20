<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\EbayUser;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method EbayUser find($id)
 * @method EbayUser[] findAll()
 * @method EbayUser[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method EbayUser findOneBy(array $criteria)
 */
interface EbayUserRepository extends ObjectRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return EbayUser
     */
    public function get(int $id): EbayUser;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return EbayUser
     */
    public function getOneBy(array $criteria): EbayUser;

    /**
     * @param string $ebayUserName
     *
     * @return EbayUser|null
     */
    public function findByEbayUsername(string $ebayUserName): ?EbayUser;

    /**
     * @param EbayUser $user
     *
     * @return mixed
     */
    public function save(EbayUser $user);
}
