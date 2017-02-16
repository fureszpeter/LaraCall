<?php
namespace LaraCall\Domain\Collections;

use InvalidArgumentException;
use LaraCall\Domain\Entities\Pin;
use stdClass;
use TestCase;

class PinCollectionTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_cant_add_wrong_instance_through_constructor()
    {
        new PinCollection([new stdClass()]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_cant_add_wrong_instance_through_add()
    {
        $collection = new PinCollection();
        $collection[] = new stdClass();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_cant_set_wrong_instance()
    {
        $mockEntity = new Pin('123');

        $collection = new PinCollection();
        $collection[] = $mockEntity;

        $collection[0] = new stdClass();
    }

    public function test_can_add_right_instance()
    {
        $mockEntity = new Pin('123');

        $collection = new PinCollection([$mockEntity]);

        $this->assertSame($mockEntity, $collection->first());
    }

    public function test_can_find_by_pin()
    {
        $mockEntity1 = new Pin('123');
        $mockEntity2 = new Pin('234');

        $collection = new PinCollection([$mockEntity1, $mockEntity2]);

        $this->assertSame($mockEntity2, $collection->findByPin('234'));
    }
}

