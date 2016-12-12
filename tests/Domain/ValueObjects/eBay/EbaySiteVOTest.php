<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use TestCase;

/**
 * Class EbaySiteVOTest.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class EbaySiteVOTest extends TestCase
{
    /**
     * @dataProvider validSiteProvider
     *
     * @param string $countryCode
     */
    public function test_can_create_valid_code($countryCode)
    {
        $ebaySite = new EbaySiteVO($countryCode);

        $this->assertEquals($countryCode, (string) $ebaySite);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_throws_on_non_string()
    {
        new EbaySiteVO(123);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function test_throws_exception_on_not_included_country_code()
    {
        new EbaySiteVO('HU');
    }

    /**
     * @return array
     */
    public function validSiteProvider()
    {
        return [
            ['US'],
            ['IT'],
        ];
    }
}
