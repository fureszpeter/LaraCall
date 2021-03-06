<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\EbayUser;
use LaraCall\Domain\Repositories\EbayUserRepository;
use OutOfBoundsException;

class DoctrineEbayUserRepository extends EntityRepository implements EbayUserRepository
{
    /**
     * @param int $id
     *
     * @throws OutOfBoundsException
     *
     * @return EbayUser
     */
    public function get(int $id): EbayUser
    {
        if ($entity = $this->find($id)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('EbayUserEntity not found by id. [id: %s]', $id)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return EbayUser
     */
    public function getOneBy(array $criteria): EbayUser
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('EbayUserEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }

    /**
     * @param EbayUser $user
     *
     * @return EbayUser
     */
    public function save(EbayUser $user): EbayUser
    {
        $this->_em->persist($user);
        $this->_em->flush($user);

        return $user;
    }

    /**
     * @param string $ebayUserName
     *
     * @return EbayUser|null
     */
    public function findByEbayUsername(string $ebayUserName): ?EbayUser
    {
        return $this->findOneBy(['ebayUserId' => $ebayUserName]);
    }
}
