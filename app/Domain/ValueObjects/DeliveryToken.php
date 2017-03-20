<?php
namespace LaraCall\Domain\ValueObjects;

use UnexpectedValueException;

class DeliveryToken
{
    /**
     * @var string
     */
    private $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->assertValid($token);

        $this->token = $token;
    }

    public function assertValid(string $token)
    {
        if ( ! preg_match('/^[0-9a-zA-Z]{25}$/', $token)) {
            throw new UnexpectedValueException(
                sprintf(
                    'Invalid token received. Token must be 25 length. [token: %s]',
                    $token
                )
            );
        }
    }

    public function __toString()
    {
        return $this->getToken();
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
