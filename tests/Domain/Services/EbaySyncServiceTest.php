<?php
namespace LaraCall\Domain\Services;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use LaraCall\Domain\Entities\EbaySyncLog;
use LaraCall\Domain\ValueObjects\DateTime;
use TestCase;

class EbaySyncServiceTest extends TestCase
{


    public function testGetLastSyncDate()
    {
        $expectedDate = DateTime::createFromFormat('Y-m-d H:i:s', '2011-01-01 1:00:00');

        $mockEbaySyncLog = $this->getMockBuilder(EbaySyncLog::class)->disableOriginalConstructor()->getMock();
        $mockEbaySyncLog->method('getRangeTo')->willReturn($expectedDate);

        $mockObjectRepository = $this->getMock(ObjectRepository::class);
        $mockObjectRepository->expects($this->once())
            ->method('findBy')
            ->willReturn([$mockEbaySyncLog]);

        $mockEntityManager = $this->getMock(EntityManagerInterface::class);
        $mockEntityManager->method('getRepository')->willReturn($mockObjectRepository);

        $service = new EbaySyncService($mockEntityManager);

        $date = $service->getLastSyncDate();

        $this->assertEquals($expectedDate, $date);
    }
}

