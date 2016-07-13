<?php
namespace LaraCall\Domain\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Furesz\TypeChecker\TypeChecker;
use InvalidArgumentException;
use JsonSerializable;
use LaraCall\Domain\Entities\User;
use UnexpectedValueException;

/**
 * Class PinCollection.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class UserCollection extends ArrayCollection implements JsonSerializable
{
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param User $user
     *
     * @throws InvalidArgumentException If $pin is not Pin.
     * @throws UnexpectedValueException If $pin is already in the collection.
     *
     * @return bool
     */
    public function add($user)
    {
        TypeChecker::assertInstanceOf($user, User::class);

        if ($this->contains($user)) {
            throw new UnexpectedValueException(
                sprintf('User already in the collection. [User: %s]', $user)
            );
        }

        return parent::add($user);
    }

    /**
     * @param User $user
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
