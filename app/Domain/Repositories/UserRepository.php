<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\User;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method User|null find($id)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method User findOneBy(array $criteria)
 */
interface UserRepository extends ObjectRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return User
     */
    public function get(int $id): User;

    /**
     * @param string $email
     *
     * @return User
     *
     * @throws OutOfBoundsException If User not exists.
     */
    public function getByEmail(string $email): User;

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function findByEmail(string $email): User;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return User
     */
    public function getOneBy(array $criteria): User;
}
