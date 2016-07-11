<?php
namespace LaraCall\Domain\ValueObjects;

use Furesz\TypeChecker\TypeChecker;
use InvalidArgumentException;
use JsonSerializable;
use UnexpectedValueException;

/**
 * Class Pin.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class Pin implements JsonSerializable
{
    /**
     * @var string
     */
    private $pin;

    /**
     * @param string $pin
     */
    public function __construct($pin)
    {
        $this->setPin($pin);
    }

    /**
     * @param string $pin
     *
     * @throws InvalidArgumentException If $pin is not a string.
     * @throws UnexpectedValueException If $pin is not acceptable.
     *
     * @return $this
     */
    public function setPin($pin)
    {
        TypeChecker::assertString($pin, '$pin');

        if (!preg_match('/^[0-9]{10,10}$/', $pin)){
            throw new UnexpectedValueException(
                sprintf('Pin is invalid. [received: %s]', $pin)
            );
        }
        
        $this->pin = $pin;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getPin();
    }

    /**
     * @return string
     */
    function jsonSerialize()
    {
        return $this->pin;
    }
}
