<?php
namespace LaraCall\Infrastructure\Services;

use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\Factories\PaymentStatusFactory;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedPayPalIpn;
use LaraCall\Domain\Services\PayPalIpnService as PayPalIpnServiceInterface;
use LaraCall\Domain\ValueObjects\IpnType;
use LaraCall\Domain\ValueObjects\PaymentStatus;

class PayPalIpnService implements PayPalIpnServiceInterface
{
    /**
     * @var string
     */
    private $receiverEmail;

    /**
     * @var PaymentStatusFactory
     */
    private $paymentStatusFactory;

    /**
     * @param string               $receiverEmail
     * @param PaymentStatusFactory $paymentStatusFactory
     */
    public function __construct(string $receiverEmail, PaymentStatusFactory $paymentStatusFactory)
    {
        $this->receiverEmail = $receiverEmail;
        $this->paymentStatusFactory = $paymentStatusFactory;
    }

    /**
     * @param ValidatedPayPalIpn $ipnSalesMessage
     *
     * @return IpnType
     */
    public function getIpnType(ValidatedPayPalIpn $ipnSalesMessage): IpnType
    {
        if ($ipnSalesMessage->isEbay()) {
            return new IpnType(IpnType::TYPE_PAYPAL_EBAY);
        }

        if (
            array_key_exists('txn_type', $ipnSalesMessage->getRawPayPalData())
            && $ipnSalesMessage->getRawPayPalData()['txn_type'] == 'web_accept'
        ) {
            return new IpnType(IpnType::TYPE_PAYPAL_WEB);
        }

        return new IpnType(IpnType::TYPE_PAYPAL_OTHER);
    }

    /**
     * @param PayPalIpn $ipnEntity
     *
     * @return bool
     */
    public function isValid(PayPalIpn $ipnEntity): bool
    {
        return $ipnEntity->getIsValid() && $ipnEntity->getSalesMessage()->getReceiverEmail() == $this->receiverEmail;
    }

    /**
     * @param ValidatedPayPalIpn $ipnSalesMessage
     *
     * @return PaymentStatus
     */
    public function getPaymentStatus(ValidatedPayPalIpn $ipnSalesMessage): PaymentStatus
    {
        return $this->paymentStatusFactory->createFromPayPalIpn($ipnSalesMessage->getRawPayPalData());
    }
}
