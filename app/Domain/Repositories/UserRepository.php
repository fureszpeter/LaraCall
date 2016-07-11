<?php

namespace LaraCall\Domain\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\User;

interface UserRepository extends ObjectRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     *
     * @throws \OutOfBoundsException If not found.

     * @return User
     */
    public function getOneBy(array $criteria, array $orderBy = null);

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function save(User $user);

    /**
     * @return void
     */
    public function commit();
}
