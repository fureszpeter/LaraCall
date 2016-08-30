<?php
namespace LaraCall\Domain\Services;

use LaraCall\Domain\ValueObjects\DateTime;
use TestCase;

class EbaySyncServiceTest extends TestCase
{


    public function testGetLastSyncDate()
    {
        $expectedDate = DateTime::createFromFormat('Y-m-d H:i:s', '2011-01-01 1:00:00');

        $service = new EbaySyncService();

        $date = $service->getLastSyncDate();

        $this->assertEquals($expectedDate, $date);
    }
}

