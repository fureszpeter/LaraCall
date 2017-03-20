<?php
namespace LaraCall\Domain\PriceList;

class CallRate
{
    /**
     * @var string
     */
    private $routeName;

    /**
     * @var float
     */
    private $price;

    /**
     * @param string  $routeName
     * @param float   $price
     */
    public function __construct(string $routeName, float $price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
