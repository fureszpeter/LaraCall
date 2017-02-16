<?php

namespace LaraCall\Domain\PriceList;

interface PriceListService
{
    /**
     * @return CallRate[]
     */
    public function getCountries(): array;
}
