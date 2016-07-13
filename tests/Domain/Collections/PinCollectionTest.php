<?php
use LaraCall\Domain\Collections\PinCollection;
use LaraCall\Domain\ValueObjects\Pin;

/**
 * Class PinCollectionTest.
 *
 * @license Proprietary
 */
class PinCollectionTest extends TestCase
{
    public function testCanAddPinInstance()
    {
        $pin = new Pin('1234567890');

        $collection = new PinCollection();

        $collection->add($pin);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowExceptionOnInvalidObject()
    {
        $collection = new PinCollection();

        $collection->add('123');
    }

    public function testToStringProvideJsonArray()
    {
        $pins = ['1234567890', '2345678901'];

        $collection = new PinCollection();
        foreach ($pins as $pin) {
            $collection->add(new Pin($pin));
        }

        $this->assertJsonStringEqualsJsonString(
            json_encode($pins),
            (string) $collection);
    }

    public function testCanParseJsonString()
    {
        $pins = ['1234567890', '2345678901'];

        $json = json_encode($pins);

        $collection = new PinCollection();

        $collection->fromJson($json);

        $this->assertEquals($pins, $collection->toArray());
    }

    public function testContainsReturnFalseIfNotContains()
    {
        $pins = ['1234567890', '2345678901'];

        $json = json_encode($pins);

        $collection = new PinCollection();

        $collection->fromJson($json);

        $this->assertFalse($collection->contains(new Pin('5678901234')));
    }

    public function testContainsReturnTrueIfContains()
    {
        $pins = ['1234567890', '2345678901'];

        $json = json_encode($pins);

        $collection = new PinCollection();

        $collection->fromJson($json);

        $this->assertTrue($collection->contains(new Pin('2345678901')));
    }
}
