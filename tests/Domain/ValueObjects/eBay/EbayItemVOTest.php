<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use TestCase;

/**
 * Class EbayItemVOTest.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class EbayItemVOTest extends TestCase
{

    public function test_can_create_valid_item_id()
    {
        $expectedId = '110181384286';
        $itemVO = new EbayItemIdVO($expectedId);

        $this->assertEquals($expectedId, $itemVO);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_will_throw_exception_on_non_string()
    {
        new EbayItemIdVO(123);
    }

    /**
     * @expectedException \UnexpectedValueException
     * @dataProvider unexpectedItemIdProvider
     *
     * @param string $unexpectedItemId
     */
    public function test_throw_exception_on_invalid_item_id($unexpectedItemId)
    {
        new EbayItemIdVO($unexpectedItemId);
    }

    /**
     * @return array
     */
    public function unexpectedItemIdProvider()
    {
        return [
//            too long
            ['110181384286' . '1'],
//            too short
            ['11018138428'],
//            invalid character
            ['11018-38428'],
        ];
    }
}

