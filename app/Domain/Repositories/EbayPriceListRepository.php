<?php

namespace LaraCall\Domain\Repositories;


use Doctrine\Common\Persistence\ObjectRepository;
use LaraCall\Domain\Entities\EbayPriceList;
use OutOfBoundsException;

/**
 * @package LaraCall\Domain\Repositories
 *
 * @method EbayPriceList find($itemId)
 * @method EbayPriceList[] findAll()
 * @method EbayPriceList[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method EbayPriceList findOneBy(array $criteria)
 */
interface EbayPriceListRepository extends ObjectRepository
{
    /**
     * @param string $itemId
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPriceList
     */
    public function get(string $itemId): EbayPriceList;

    /**
     * @param array $criteria
     *
     * @throws OutOfBoundsException
     *
     * @return EbayPriceList
     */
    public function getOneBy(array $criteria): EbayPriceList;
}
