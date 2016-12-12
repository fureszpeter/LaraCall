<?php
namespace LaraCall\Domain\Services;

use Doctrine\ORM\EntityManagerInterface;
use DTS\eBaySDK\Trading\Enums\CheckoutStatusCodeType;
use DTS\eBaySDK\Trading\Enums\CompleteStatusCodeType;
use LaraCall\Domain\Repositories\EbayItemRepository;
use LaraCall\Domain\ValueObjects\OrderStatusVO;
use LaraCall\Domain\ValueObjects\TransactionParseResult;

/**
 * Class EbayTransactionDataParser.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class EbayTransactionDataParser implements TransactionDataParser
{
    /**
     * @var EbayItemRepository
     */
    private $ebayListingRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     * @param EbayItemRepository     $ebayListingRepository
     */
    public function __construct(
        EntityManagerInterface $em,
        EbayItemRepository $ebayListingRepository
    ) {
        $this->em                    = $em;
        $this->ebayListingRepository = $ebayListingRepository;
    }

    /**
     * @param mixed $data
     *
     * @return TransactionParseResult
     */
    public function parse($data)
    {
        $itemId           = $data->Item->ItemID;
        $quantity         = $data->QuantityPurchased;
        $amountPayed      = floatval($data->AmountPaid->value);
        $soldPricePerItem = floatval($data->ConvertedTransactionPrice->value);

        $orderStatus = $this->getOrderStatus($data);

        return new TransactionParseResult(
            $orderStatus,
            $itemId,
            $quantity,
            $soldPricePerItem,
            $amountPayed
        );
    }

    /**
     * @param mixed $data
     *
     * @return OrderStatusVO
     */
    public function getOrderStatus($data)
    {
        $orderStatus = OrderStatusVO::STATUS_PROCESS_ERROR();

        $itemId = $data->Item->ItemID;

        if ( ! $this->ebayListingRepository->find($itemId)) {
            $orderStatus = OrderStatusVO::STATUS_INDIFFERENT();

            return $orderStatus;
        }

        if (
            $data->Status->CheckoutStatus == CheckoutStatusCodeType::C_CHECKOUT_COMPLETE
            && $data->Status->CompleteStatus == CompleteStatusCodeType::C_COMPLETE
        ) {
            $orderStatus = OrderStatusVO::STATUS_PAYED();

            return $orderStatus;
        }

        if ($data->Status->CompleteStatus == CompleteStatusCodeType::C_INCOMPLETE) {
            $orderStatus = OrderStatusVO::STATUS_WAIT_FOR_PAYMENT();

            return $orderStatus;
        }

        if ($data->Status->CompleteStatus == CompleteStatusCodeType::C_PENDING) {
            $orderStatus = OrderStatusVO::STATUS_HUMAN_REVIEW();

            return $orderStatus;
        }

        return $orderStatus;
    }
}
