<?php
use LaraCall\Domain\ValueObjects\eBay\OrderLineItemId;

/**
 * Class OrderLineItemIdTest.
 *
 * @license Proprietary
 */
class OrderLineItemIdTest extends TestCase
{
    public function test_can_create_valid_id()
    {
        $id = '110181384286-27974206001';

        new OrderLineItemId($id);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_throw_invalid_argument_exception_on_non_string()
    {
        new OrderLineItemId(123);
    }

    /**
     * @expectedException UnexpectedValueException
     *
     * @dataProvider unexpectedOrderLineProvider
     *
     * @param string $orderLineId
     */
    public function test_throw_unexpected_exception_on_not_acceptable_value($orderLineId)
    {
        new OrderLineItemId($orderLineId);
    }

    public function unexpectedOrderLineProvider()
    {
        return [
            /* Too long */
            ['1234567890123456789012345678901234567890123456789051'],
            ['123'],
            ['123-'],
            ['-123'],
        ];
    }
}
