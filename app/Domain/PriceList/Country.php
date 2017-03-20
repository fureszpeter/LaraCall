<?php
namespace LaraCall\Domain\PriceList;

class Country
{
    /**
     * @var string
     */
    private $code2;

    /**
     * @var string
     */
    private $code3;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $code2
     * @param string $code3
     * @param string $name
     */
    public function __construct(string $code2, string $code3, string $name)
    {
        $this->code2 = $code2;
        $this->code3 = $code3;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode2(): string
    {
        return $this->code2;
    }

    /**
     * @return string
     */
    public function getCode3(): string
    {
        return $this->code3;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
