<?php

namespace LaraCall\Events;

use LaraCall\Domain\Entities\EbayPaymentTransaction;
use LaraCall\Domain\Entities\EbayPriceList;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use LaraCall\Domain\Repositories\EbayPriceListRepository;
use LaraCall\Events\PaymentHandlers\AddItemsToStockIfNeeded;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use RuntimeException;
use TestCase;

class AddItemsToStockIfNeededTest extends TestCase
{

    public function test_ChangeListQuantity_Will_Update_Quantity_If_No_Exception()
    {
        $mockPriceListRepository          = $this->createMock(EbayPriceListRepository::class);
        $mockPaymentTransactionRepository = $this->createMock(EbayPaymentTransactionRepository::class);

        $mockApiService = $this
            ->getMockBuilder(EbayApiService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event = new EbayPaymentCompleteEvent(1);

        $ebayPaymentTransactionEntity = $this
            ->getMockBuilder(EbayPaymentTransaction::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ebayPriceListEntity = $this
            ->getMockBuilder(EbayPriceList::class)
            ->disableOriginalConstructor()
            ->getMock();

        $itemId = new ItemId('1234567890');

        $ebayPaymentTransactionEntity
            ->expects($this->once())
            ->method('getItemId')
            ->willReturn($itemId);

        $mockPaymentTransactionRepository
            ->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($ebayPaymentTransactionEntity);

        $ebayPriceListEntity
            ->expects($this->once())
            ->method('getMinStock')
            ->willReturn(15);

        $mockPriceListRepository
            ->expects($this->once())
            ->method('get')
            ->with((string)$itemId)
            ->willReturn($ebayPriceListEntity);

        $mockApiService
            ->expects($this->once())
            ->method('changeListingQuantity')
            ->with((string)$itemId, 15);

        $handler = new AddItemsToStockIfNeeded(
            $mockPriceListRepository,
            $mockPaymentTransactionRepository,
            $mockApiService
        );

        $handler->handle($event);

        $this->assertTrue(true);
    }

    public function test_ChangeListQuantity_Will_Update_Quantity_If_Exception_Is_BestOffer()
    {
        $mockPriceListRepository          = $this->createMock(EbayPriceListRepository::class);
        $mockPaymentTransactionRepository = $this->createMock(EbayPaymentTransactionRepository::class);

        $mockApiService = $this
            ->getMockBuilder(EbayApiService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event = new EbayPaymentCompleteEvent(1);

        $ebayPaymentTransactionEntity = $this
            ->getMockBuilder(EbayPaymentTransaction::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ebayPriceListEntity = $this
            ->getMockBuilder(EbayPriceList::class)
            ->disableOriginalConstructor()
            ->getMock();

        $itemId = new ItemId('1234567890');

        $ebayPaymentTransactionEntity
            ->expects($this->once())
            ->method('getItemId')
            ->willReturn($itemId);

        $mockPaymentTransactionRepository
            ->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($ebayPaymentTransactionEntity);

        $ebayPriceListEntity
            ->expects($this->once())
            ->method('getMinStock')
            ->willReturn(15);

        $mockPriceListRepository
            ->expects($this->once())
            ->method('get')
            ->with((string)$itemId)
            ->willReturn($ebayPriceListEntity);

        $mockApiService
            ->expects($this->once())
            ->method('changeListingQuantity')
            ->with((string)$itemId, 15)
            ->willThrowException(
                new RuntimeException('If this item sells by a Best Offer, you will not be able to require immediate payment.')
            );


        $handler = new AddItemsToStockIfNeeded(
            $mockPriceListRepository,
            $mockPaymentTransactionRepository,
            $mockApiService
        );

        $handler->handle($event);

        $this->assertTrue(true);
    }

    public function test_ChangeListQuantity_Will_Throw_Exception_If_Exception_Is_NOT_BestOffer()
    {
        $this->expectException(RuntimeException::class);

        $mockPriceListRepository          = $this->createMock(EbayPriceListRepository::class);
        $mockPaymentTransactionRepository = $this->createMock(EbayPaymentTransactionRepository::class);

        $mockApiService = $this
            ->getMockBuilder(EbayApiService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event = new EbayPaymentCompleteEvent(1);

        $ebayPaymentTransactionEntity = $this
            ->getMockBuilder(EbayPaymentTransaction::class)
            ->disableOriginalConstructor()
            ->getMock();

        $ebayPriceListEntity = $this
            ->getMockBuilder(EbayPriceList::class)
            ->disableOriginalConstructor()
            ->getMock();

        $itemId = new ItemId('1234567890');

        $ebayPaymentTransactionEntity
            ->expects($this->once())
            ->method('getItemId')
            ->willReturn($itemId);

        $mockPaymentTransactionRepository
            ->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($ebayPaymentTransactionEntity);

        $ebayPriceListEntity
            ->expects($this->once())
            ->method('getMinStock')
            ->willReturn(15);

        $mockPriceListRepository
            ->expects($this->once())
            ->method('get')
            ->with((string)$itemId)
            ->willReturn($ebayPriceListEntity);

        $mockApiService
            ->expects($this->once())
            ->method('changeListingQuantity')
            ->with((string)$itemId, 15)
            ->willThrowException(
                new RuntimeException('Fatal error!')
            );

        $handler = new AddItemsToStockIfNeeded(
            $mockPriceListRepository,
            $mockPaymentTransactionRepository,
            $mockApiService
        );

        $handler->handle($event);

        $this->assertTrue(true);
    }

}

