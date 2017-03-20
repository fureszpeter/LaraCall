<?php
namespace LaraCall\Infrastructure\Services\Ebay;

use DTS\eBaySDK\MerchantData\Enums\DetailLevelCodeType;
use DTS\eBaySDK\Shopping\Services\ShoppingService;
use DTS\eBaySDK\Trading\Enums\OrderStatusFilterCodeType;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\AddMemberMessageAAQToPartnerRequestType;
use DTS\eBaySDK\Trading\Types\CompleteSaleRequestType;
use DTS\eBaySDK\Trading\Types\CompleteSaleResponseType;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetBestOffersRequestType;
use DTS\eBaySDK\Trading\Types\GetBestOffersResponseType;
use DTS\eBaySDK\Trading\Types\GetItemTransactionsRequestType;
use DTS\eBaySDK\Trading\Types\GetMyeBaySellingRequestType;
use DTS\eBaySDK\Trading\Types\GetMyeBaySellingResponseType;
use DTS\eBaySDK\Trading\Types\GetSellerTransactionsRequestType;
use DTS\eBaySDK\Trading\Types\GetSellerTransactionsResponseType;
use DTS\eBaySDK\Trading\Types\GetUserDisputesRequestType;
use DTS\eBaySDK\Trading\Types\GetUserRequestType;
use DTS\eBaySDK\Trading\Types\GetUserResponseType;
use DTS\eBaySDK\Trading\Types\InventoryStatusType;
use DTS\eBaySDK\Trading\Types\ItemListCustomizationType;
use DTS\eBaySDK\Trading\Types\MemberMessageType;
use DTS\eBaySDK\Trading\Types\PaginationType;
use DTS\eBaySDK\Trading\Types\ReviseInventoryStatusRequestType;
use DTS\eBaySDK\Trading\Types\TransactionType;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use RuntimeException;

/**
 * Class EbayService.
 *
 *
 * @license Proprietary
 */
class EbayApiService
{
    /**
     * @var TradingService
     */
    private $tradingService;

    /**
     * @var CustomSecurityHeaderType
     */
    private $customSecurityHeaderType;

    /**
     * @var ShoppingService
     */
    private $shoppingService;

    /**
     * @param TradingService           $service
     * @param CustomSecurityHeaderType $customSecurityHeaderType
     * @param ShoppingService          $shoppingService
     */
    public function __construct(
        TradingService $service,
        CustomSecurityHeaderType $customSecurityHeaderType,
        ShoppingService $shoppingService
    ) {
        $this->tradingService           = $service;
        $this->customSecurityHeaderType = $customSecurityHeaderType;
        $this->shoppingService          = $shoppingService;
    }

    /**
     * @param string            $itemId
     * @param MemberMessageType $memberMessageType
     *
     * @throws RuntimeException IF message send fails.
     *
     * @return string
     */
    public function sendMessageToBuyer($itemId, MemberMessageType $memberMessageType)
    {
        $request                       = new AddMemberMessageAAQToPartnerRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ItemID               = $itemId;
        $request->MemberMessage        = $memberMessageType;

        $response = $this->tradingService->addMemberMessageAAQToPartner($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response->Message;

    }

    /**
     * @param string $itemId
     * @param string $transactionId
     *
     * @return CompleteSaleResponseType
     */
    public function markItemShipped(string $itemId, string $transactionId): CompleteSaleResponseType
    {
        $request                       = new CompleteSaleRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ItemID               = $itemId;
        $request->TransactionID        = $transactionId;
        $request->Shipped              = true;

        $response = $this->tradingService->completeSale($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;
    }

    /**
     * @param $itemId
     * @param $transactionId
     *
     * @return string[] Array of orderLineId
     */
    public function search($itemId, $transactionId)
    {
        $request                       = new GetItemTransactionsRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;

        $request->ItemID        = $itemId;
        $request->TransactionID = $transactionId;

        $response = $this->tradingService->getItemTransactions($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        $orderLineIds = [];
        foreach ($response->TransactionArray->Transaction as $transaction) {
            /** @var TransactionType $transaction */
            $orderLineIds[] = $transaction->toArray();
        }

        return $orderLineIds;
    }

    /**
     * @param string $userId
     * @param ItemId $itemId
     *
     * @return GetUserResponseType
     */
    public function getUser(string $userId, ItemId $itemId = null): GetUserResponseType
    {
        $request                       = new GetUserRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->UserID               = $userId;
        if ($itemId) {
            $request->ItemID = $itemId;
        }

        $response = $this->tradingService->getUser($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;
    }

    /**
     * @return GetMyeBaySellingResponseType
     */
    public function getUnShippedTransactions()
    {
        return $this->getTransactions(OrderStatusFilterCodeType::C_AWAITING_SHIPMENT);
    }

    /**
     * @param string $orderStatusFilterCode
     *
     * @return GetMyeBaySellingResponseType
     */
    public function getTransactions(string $orderStatusFilterCode): GetMyeBaySellingResponseType
    {
        $request                       = new GetMyeBaySellingRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;

        $itemListCustomization                    = new ItemListCustomizationType();
        $itemListCustomization->OrderStatusFilter = $orderStatusFilterCode;
        $request->SoldList                        = $itemListCustomization;

        $response = $this->tradingService->getMyeBaySelling($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;
    }

    /**
     * @return GetMyeBaySellingResponseType
     */
    public function getShippedAndNoFeedbackTransactions()
    {
        $transactions = $this->getTransactions(OrderStatusFilterCodeType::C_PAID_AND_SHIPPED);

        return $transactions;
    }

    /**
     * @param ItemId $itemId
     * @param string $transactionId
     *
     * @return TransactionType
     */
    public function getTransaction(ItemId $itemId, string $transactionId): TransactionType
    {
        $request                       = new GetItemTransactionsRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ItemID               = $itemId->getItemId();
        $request->TransactionID        = $transactionId;

        $response = $this->tradingService->getItemTransactions($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        $current = current($response->TransactionArray->Transaction);

        return current($current);
    }

    /**
     * @return array
     */
    public function getMyInfo(): array
    {
        $request                       = new GetUserRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->DetailLevel          = [DetailLevelCodeType::C_RETURN_ALL];


        $response = $this->tradingService->getUser($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response->toArray();
    }


    /**
     * @return GetMyeBaySellingResponseType
     */
    public function getForSaleItems(): GetMyeBaySellingResponseType
    {
        $request                       = new GetMyeBaySellingRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;

        $customisation          = new ItemListCustomizationType();
        $customisation->Include = true;
        $request->ActiveList    = $customisation;

        $response = $this->tradingService->getMyeBaySelling($request);
        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;

    }

    /**
     * @return GetSellerTransactionsResponseType
     */
    public function getSellerTransactions(): GetSellerTransactionsResponseType
    {
        $request                       = new GetSellerTransactionsRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;

        $pagination                 = new PaginationType();
        $pagination->EntriesPerPage = 200;
        $request->Pagination        = $pagination;

        $request->NumberOfDays = 30;

        $response = $this->tradingService->getSellerTransactions($request);
        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;
    }

    /**
     * @return GetBestOffersResponseType
     */
    public function getBestOffers(): GetBestOffersResponseType
    {
        $request                       = new GetBestOffersRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;

        $response = $this->tradingService->getBestOffers($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;
    }

    /**
     * @return \DTS\eBaySDK\Trading\Types\GetUserDisputesResponseType
     */
    public function getDisputes()
    {
        $request                       = new GetUserDisputesRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->DetailLevel          = [DetailLevelCodeType::C_RETURN_ALL];

        $pagination                 = new PaginationType();
        $pagination->EntriesPerPage = 200;
        $pagination->PageNumber     = 1;
        $request->Pagination        = $pagination;


        $response = $this->tradingService->getUserDisputes($request);
        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;
    }

    /**
     * @param ItemId $itemId
     * @param int    $quantity
     *
     * @return \DTS\eBaySDK\Trading\Types\ReviseInventoryStatusResponseType
     */
    public function changeListingQuantity(ItemId $itemId, int $quantity)
    {
        $request                       = new ReviseInventoryStatusRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;

        $inventoryStatus           = new InventoryStatusType();
        $inventoryStatus->Quantity = $quantity;
        $inventoryStatus->ItemID   = $itemId->getItemId();

        $request->InventoryStatus = [$inventoryStatus];

        $response = $this->tradingService->reviseInventoryStatus($request);
        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response;
    }
}
