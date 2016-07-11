<?php
namespace LaraCall\Domain\ValueObjects;

use Furesz\TypeChecker\TypeChecker;
use InvalidArgumentException;

/**
 * Class Password.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class Password
{
    /**
     * @var string
     */
    private $password;

    /**
     * @param string $password
     */
    public function __construct($password)
    {
        $this->setPassword($password);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @throws InvalidArgumentException If value is not a string.
     *
     * @return $this
     */
    private function setPassword($password)
    {
        TypeChecker::assertString($password, '$password');

        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getPassword();
    }
}
