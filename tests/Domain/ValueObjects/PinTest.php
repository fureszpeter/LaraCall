<?php
namespace LaraCall\Domain\ValueObjects;

use TestCase;
use UnexpectedValueException;

/**
 * Class PinTest.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class PinTest extends TestCase
{

    public function testGetPin()
    {
        $code = '1234567890';

        $pin = new Pin($code);

        $this->assertEquals($code, (string)$pin);
        $this->assertEquals($code, $pin->getPin());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowInvalidArgumentException()
    {
        new Pin(123);
    }

    /**
     * @dataProvider unexpectedPinProvider
     *
     * @expectedException UnexpectedValueException
     *
     * @param string $code
     */
    public function testThrowUnexpectedArgumentException($code)
    {
        new Pin($code);
    }

    /**
     * @return array
     */
    public function unexpectedPinProvider()
    {
        return [
            ['sdsfds'],
            //Too short
            ['123456789'],
            //Too long
            ['12345678901']
        ];
    }
}

