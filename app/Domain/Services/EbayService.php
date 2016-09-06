<?php
namespace LaraCall\Domain\Services;

use DateTime;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetAccountRequestType;
use DTS\eBaySDK\Trading\Types\GeteBayOfficialTimeRequestType;
use DTS\eBaySDK\Trading\Types\GetItemTransactionsRequestType;
use DTS\eBaySDK\Trading\Types\GetOrderTransactionsRequestType;
use DTS\eBaySDK\Trading\Types\GetSellerTransactionsRequestType;
use DTS\eBaySDK\Trading\Types\ItemTransactionIDArrayType;
use DTS\eBaySDK\Trading\Types\ItemTransactionIDType;
use DTS\eBaySDK\Trading\Types\OrderArrayType;
use DTS\eBaySDK\Trading\Types\TransactionArrayType;
use LaraCall\Domain\Entities\EbayTransactionLog;
use LaraCall\Domain\ValueObjects\PastDateRange;
use RuntimeException;

/**
 * Class EbayService.
 *
 *
 * @license Proprietary
 */
class EbayService
{
    /**
     * @var TradingService
     */
    private $service;

    /**
     * @var CustomSecurityHeaderType
     */
    private $customSecurityHeaderType;

    /**
     * @param TradingService           $service
     * @param CustomSecurityHeaderType $customSecurityHeaderType
     */
    public function __construct(TradingService $service, CustomSecurityHeaderType $customSecurityHeaderType)
    {
        $this->service                  = $service;
        $this->customSecurityHeaderType = $customSecurityHeaderType;
    }

    /**
     * @param string        $itemId
     * @param PastDateRange $dateRange
     *
     * @throws RuntimeException If something went wrong during the query.
     *
     * @return array
     */
    public function getItemTransactions($itemId, PastDateRange $dateRange)
    {
        $request                       = new GetItemTransactionsRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ItemID               = $itemId;
        $request->ModTimeFrom          = new DateTime($dateRange->getDateFrom());
        $request->ModTimeTo            = new DateTime($dateRange->getDateTo());

        $response = $this->service->getItemTransactions($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response->TransactionArray->toArray();
    }

    /**
     * @return DateTime
     */
    public function getOfficialTime()
    {
        $request  = new GeteBayOfficialTimeRequestType();
        $response = $this->service->geteBayOfficialTime($request);

        return $response->Timestamp;
    }

    /**
     * @return \DTS\eBaySDK\Trading\Types\AccountSummaryType
     */
    public function getAccountInfo()
    {
        $response = $this->service->getAccount(new GetAccountRequestType());

        return $response;
    }

    /**
     * @param PastDateRange $dateRange
     *
     * @throws RuntimeException If error occurs during the query.
     *
     * @return TransactionArrayType
     */
    public function getSellerTransactions(PastDateRange $dateRange)
    {
        $request                       = new GetSellerTransactionsRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ModTimeFrom          = $dateRange->getDateFrom();
        $request->ModTimeTo            = $dateRange->getDateTo();

        $response = $this->service->getSellerTransactions($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        if ($response->TransactionArray) {
            return $response->TransactionArray;
        } else {
            return new TransactionArrayType([]);
        }
    }

    /**
     * @param \LaraCall\Domain\Entities\EbayTransactionLog[] ...$ebayTransactionLogs
     *
     * @return OrderArrayType
     */
    public function getOrderTransaction(EbayTransactionLog ...$ebayTransactionLogs)
    {
        $request                         = new GetOrderTransactionsRequestType();
        $request->RequesterCredentials   = $this->customSecurityHeaderType;
        $transactionIds                  = array_map(
            function (EbayTransactionLog $transactionLog) {
                return $transactionLog->getTransactionId();
            },
            $ebayTransactionLogs
        );
        $request->ItemTransactionIDArray = new ItemTransactionIDArrayType();
        foreach ($transactionIds as $transactionId) {
            $itemTransactionIDType                                = new ItemTransactionIDType();
            $itemTransactionIDType->OrderLineItemID               = $transactionId;
            $request->ItemTransactionIDArray->ItemTransactionID[] = $itemTransactionIDType;
        }

        $response = $this->service->getOrderTransactions($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        if ($response->OrderArray) {
            return $response->OrderArray;
        } else {
            return new OrderArrayType([]);
        }


    }
}
