<?php
namespace LaraCall\Domain\Services;

use DateTime;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetItemTransactionsRequestType;
use LaraCall\Domain\ValueObjects\PastDateRange;
use LaravelDoctrine\ORM\Configuration\MetaData\Config;
use RuntimeException;

/**
 * Class EbayService.
 *
 * @package LaraCall
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
        $this->service = $service;
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
        $request = new GetItemTransactionsRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ItemID = $itemId;
        $request->ModTimeFrom = new DateTime($dateRange->getDateFrom());
        $request->ModTimeTo = new DateTime($dateRange->getDateTo());

        $response = $this->service->getItemTransactions($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                throw new RuntimeException($error->LongMessage);
            }
        }

        return $response->TransactionArray->toArray();
    }
}
