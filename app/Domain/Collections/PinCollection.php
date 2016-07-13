<?php
namespace LaraCall\Domain\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Furesz\TypeChecker\TypeChecker;
use InvalidArgumentException;
use JsonSerializable;
use LaraCall\Domain\ValueObjects\Pin;
use UnexpectedValueException;

/**
 * Class PinCollection.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class PinCollection extends ArrayCollection implements JsonSerializable
{
    /**
     * @param Pin $user
     *
     * @throws InvalidArgumentException If $pin is not Pin.
     * @throws UnexpectedValueException If $pin is already in the collection.
     *
     * @return bool
     */
    public function add($user)
    {
        TypeChecker::assertInstanceOf($user, Pin::class);

        if ($this->contains($user)) {
            throw new UnexpectedValueException(
                sprintf('PIN already in the collection. [pin: %s]', $user)
            );
        }

        return parent::add($user);
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param string $json
     *
     * @throws InvalidArgumentException If json is not a string.
     * @throws \UnexpectedValueException If json is invalid.
     * @throws \UnexpectedValueException If json is not an array.
     *
     * @return $this
     */
    public function fromJson($json)
    {
        TypeChecker::assertString($json, '$json');

        $pins = json_decode($json);

        if (is_null($pins)) {
            throw new UnexpectedValueException(
                sprintf('json is invalid. %s', $json)
            );
        }

        if (!is_array($pins)) {
            throw new UnexpectedValueException(
                sprintf('json should be an array. %s', $json)
            );
        }

        foreach ($pins as $pin) {
            $this->add(new Pin($pin));
        }

        return $this;
    }

    /**
     * @param Pin $user
     *
     * @return bool
     */
    public function contains($user)
    {
        return in_array($user, $this->toArray());
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
