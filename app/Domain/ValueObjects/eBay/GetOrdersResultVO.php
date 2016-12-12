<?php
namespace LaraCall\Domain\ValueObjects\eBay;

use DateTimeInterface;
use DTS\eBaySDK\Trading\Types\TransactionArrayType;
use DTS\eBaySDK\Trading\Types\TransactionType;
use Furesz\TypeChecker\TypeChecker;
use JsonSerializable;

/**
 * Class GetOrdersResultVO.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class GetOrdersResultVO implements JsonSerializable
{
    /**
     * @var OrderLineItemId
     */
    private $orderId;

    /**
     * @var CheckoutStatusVO
     */
    private $checkoutStatus;

    /**
     * @var PaymentStatusVO
     */
    private $paymentStatus;

    /**
     * @var float
     */
    private $amountPayed;

    /**
     * @var DateTimeInterface|null
     */
    private $paymentDate;

    /**
     * @var TransactionArrayType
     */
    private $transactions;

    /**
     * @param OrderLineItemId      $orderId
     * @param CheckoutStatusVO     $checkoutStatus
     * @param PaymentStatusVO      $paymentStatus
     * @param float                $amountPayed
     * @param TransactionArrayType $transactions
     * @param DateTimeInterface    $paymentDate
     */
    public function __construct(
        OrderLineItemId $orderId,
        CheckoutStatusVO $checkoutStatus,
        PaymentStatusVO $paymentStatus,
        $amountPayed,
        TransactionArrayType $transactions,
        DateTimeInterface $paymentDate = null
    ) {
        TypeChecker::assertDouble($amountPayed, '$amountPayed');

        $this->orderId        = $orderId;
        $this->checkoutStatus = $checkoutStatus;
        $this->paymentStatus  = $paymentStatus;
        $this->amountPayed    = $amountPayed;
        $this->paymentDate    = $paymentDate;
        $this->transactions = $transactions;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'orderId'        => $this->getOrderId(),
            'checkoutStatus' => $this->getCheckoutStatus(),
            'paymentStatus'  => $this->getPaymentStatus(),
            'amountPayed'    => $this->getAmountPayed(),
            'paymentDate'    => $this->getPaymentDate(),
            'transactions'   => $this->getTransactions(),
        ];
    }

    /**
     * @return TransactionType[]
     */
    public function getTransactions()
    {
        $transactions = [];
        foreach ($this->transactions->Transaction as $transaction) {
            $transactions[] = $transaction->toArray();
        }

        return $transactions;
    }

    /**
     * @return OrderLineItemId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return CheckoutStatusVO
     */
    public function getCheckoutStatus()
    {
        return $this->checkoutStatus;
    }

    /**
     * @return PaymentStatusVO
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @return float
     */
    public function getAmountPayed()
    {
        return $this->amountPayed;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }
}
