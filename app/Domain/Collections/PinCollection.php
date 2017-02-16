<?php
namespace LaraCall\Domain\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Furesz\TypeChecker\TypeChecker;
use LaraCall\Domain\Entities\Pin;

class PinCollection extends ArrayCollection
{
    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            TypeChecker::assertInstanceOf($element, Pin::class);
        }

        parent::__construct($elements);
    }

    /**
     * @param Pin $value
     *
     * @return bool
     */
    public function add($value)
    {
        TypeChecker::assertInstanceOf($value, Pin::class);

        return parent::add($value);
    }

    /**
     * @param int|string $key
     * @param Pin        $value
     */
    public function set($key, $value)
    {
        TypeChecker::assertInstanceOf($value, Pin::class);

        parent::set($key, $value);
    }

    /**
     * @param string $pin
     *
     * @return Pin|null
     */
    public function findByPin(string $pin): ?Pin
    {
        return $this->filter(function (Pin $pinEntity) use ($pin) {
            return $pinEntity->getPin() == $pin;
        })->first();
    }
}
