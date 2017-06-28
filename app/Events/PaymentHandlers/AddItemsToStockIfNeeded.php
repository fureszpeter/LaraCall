<?php

namespace LaraCall\Events\PaymentHandlers;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaraCall\Domain\Repositories\EbayPaymentTransactionRepository;
use LaraCall\Domain\Repositories\EbayPriceListRepository;
use LaraCall\Events\EbayPaymentCompleteEvent;
use LaraCall\Infrastructure\Services\Ebay\EbayApiService;

class AddItemsToStockIfNeeded implements ShouldQueue
{
    /**
     * @var EbayPriceListRepository
     */
    private $priceListRepository;
    /**
     * @var EbayPaymentTransactionRepository
     */
    private $ebayPaymentTransactionRepository;
    /**
     * @var EbayApiService
     */
    private $apiService;

    /**
     * @param EbayPriceListRepository $priceListRepository
     * @param EbayPaymentTransactionRepository $ebayPaymentTransactionRepository
     * @param EbayApiService $apiService
     */
    public function __construct(
        EbayPriceListRepository $priceListRepository,
        EbayPaymentTransactionRepository $ebayPaymentTransactionRepository,
        EbayApiService $apiService
    ) {
        $this->priceListRepository              = $priceListRepository;
        $this->ebayPaymentTransactionRepository = $ebayPaymentTransactionRepository;
        $this->apiService                       = $apiService;
    }

    /**
     * @param EbayPaymentCompleteEvent $event
     *
     * @throws Exception
     */
    public function handle(EbayPaymentCompleteEvent $event)
    {
        $paymentTransaction = $this->ebayPaymentTransactionRepository->get(
            $event->getEbayPaymentTransactionId()
        );

        $itemId          = $paymentTransaction->getItemId();
        $priceListEntity = $this->priceListRepository->get($itemId->getItemId());

        try {
            $this->apiService->changeListingQuantity($itemId, $priceListEntity->getMinStock());
        } catch (Exception $exception) {
            if (!preg_match('/Best Offer/i', $exception->getMessage())) {
                throw $exception;
            }
        }
    }
}
