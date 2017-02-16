<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Repositories\UserRepository;
use OutOfBoundsException;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return User
     */
    public function get(int $id): User
    {
        /** @var User|null $entity */
        if ($entity = $this->find($id)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('UserEntity not found by id. [id: %s]', $id)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return User
     */
    public function getOneBy(array $criteria): User
    {
        /** @var User|null $entity */
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('UserEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }
}
