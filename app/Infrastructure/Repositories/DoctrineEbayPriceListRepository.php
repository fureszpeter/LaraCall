<?php
namespace LaraCall\Infrastructure\Repositories;

use Doctrine\ORM\EntityRepository;
use LaraCall\Domain\Entities\EbayPriceList;
use LaraCall\Domain\Repositories\EbayPriceListRepository;
use OutOfBoundsException;

class DoctrineEbayPriceListRepository extends EntityRepository implements EbayPriceListRepository
{
    /**
     * @param string $itemId
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPriceList
     */
    public function get(string $itemId): EbayPriceList
    {
        if ($entity = $this->find($itemId)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('EbayPriceListEntity not found by id. [id: %s]', $itemId)
        );
    }

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPriceList
     */
    public function getOneBy(array $criteria): EbayPriceList
    {
        if ($entity = $this->findOneBy($criteria)) {
            return $entity;
        }

        throw new OutOfBoundsException(
            sprintf('EbayPriceListEntity not found by criteria. [criteria: %s]', implode(',', $criteria))
        );
    }
}
