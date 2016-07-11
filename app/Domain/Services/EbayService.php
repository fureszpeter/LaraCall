<?php
namespace LaraCall\Domain\Services;

use DTS\eBaySDK\Trading\Enums\SeverityCodeType;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\CustomSecurityHeaderType;
use DTS\eBaySDK\Trading\Types\GetItemTransactionsRequestType;
use LaraCall\Domain\ValueObjects\PastDateRange;
use LaravelDoctrine\ORM\Configuration\MetaData\Config;

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
     * @return array
     */
    public function getItemTransactions($itemId, PastDateRange $dateRange)
    {
        $request = new GetItemTransactionsRequestType();
        $request->RequesterCredentials = $this->customSecurityHeaderType;
        $request->ItemID = $itemId;
        $request->NumberOfDays = 2;

        $response = $this->service->getItemTransactions($request);

        if ($response->Errors) {
            foreach ($response->Errors as $error) {
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );
            }
        }

        return $response->TransactionArray->toArray();
    }
}
