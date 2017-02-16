<?php

namespace LaraCall\Domain\ValueObjects;

use TestCase;
use UnexpectedValueException;

class DeliveryTokenTest extends TestCase
{
    public function testCanCreateValidToken()
    {
        $string = str_random(25);

        $token = new DeliveryToken($string);

        $this->assertEquals($string, $token->getToken());

        $this->assertEquals($string, $token);
    }

    /**
     * @dataProvider invalidTokenProvider
     */
    public function testNonValidTokenThrowsException(string $token)
    {
        $this->setExpectedException(UnexpectedValueException::class);

        new DeliveryToken($token);
    }

    public function invalidTokenProvider()
    {
        return [
            ['tooShort'],
            [str_random(26)],
            [str_random(24) . '+'],
        ];
    }
}

