<?php

namespace LaraCall\Domain\Services;

use LaraCall\Domain\Entities\EbayPriceList;

interface PriceListService
{
    /**
     * @param string $itemId
     *
     * @return bool
     */
    public function isItemForSale(string $itemId): bool;

    /**
     * @param string $itemId
     *
     * @return EbayPriceList
     */
    public function getPriceEntity(string $itemId): EbayPriceList;
}
