<?php

namespace LaraCall\Domain\Factories;

use DateTimeImmutable;
use LaraCall\Domain\Entities\PayPalIpnEntity;
use LaraCall\Domain\PayPal\ValueObjects\PayPalIpn;
use LaraCall\Domain\ValueObjects\IpnType;
use UnexpectedValueException;

class PayPalIpnFactory
{
    /** @var PaymentStatusFactory */
    private $paymentStatusFactory;

    /**
     * @param PaymentStatusFactory $paymentStatusFactory
     */
    public function __construct(PaymentStatusFactory $paymentStatusFactory)
    {
        $this->paymentStatusFactory = $paymentStatusFactory;
    }

    /**
     * @param array $post
     *
     * @return PayPalIpn
     *
     * @throws UnexpectedValueException If IPN message is empty.
     */
    public function createFromArray(array $post): PayPalIpn
    {
        if (empty($post)) {
            throw new UnexpectedValueException('Empty IPN message not allowed for PayPal!');
        }

        $isSandBox         = $this->checkIsSandbox($post);
        $txnId             = $post['txn_id'];
        $receiverEmail     = $post['receiver_email'];
        $dateOfTransaction = new DateTimeImmutable($post['payment_date']);
        $payerEmail        = $post['payer_email'];
        $parentTxnId       = array_key_exists('parent_txn_id', $post) ? $post['parent_txn_id'] : null;
        $paymentStatus     = $post['payment_status'];
        $isEbay            = $this->isEbay($post);
        $customField       = array_key_exists('custom', $post) ? $post['custom'] : null;
        $firstName         = $post['first_name'];
        $lastName          = $post['last_name'];
        $countryCode       = empty($post['address_country_code']) ? null : $post['address_country_code'];
        $zipCode           = empty($post['address_zip']) ? null : $post['address_zip'];
        $city              = empty($post['address_city']) ? null : $post['address_city'];
        $address           = empty($post['address_street']) ? null : $post['address_street'];
        $fee               = (float)$post['mc_fee'];
        $state             = empty($post['address_state']) ? null : $post['address_state'];
        $grossAmount       = (float)$post['payment_gross'];

        return new PayPalIpn(
            $post,
            $this->getIpnType($post),
            $isSandBox,
            $txnId,
            $parentTxnId,
            $receiverEmail,
            $payerEmail,
            $dateOfTransaction,
            $this->paymentStatusFactory->createFromString($paymentStatus),
            $isEbay,
            $customField,
            $firstName,
            $lastName,
            $countryCode,
            $zipCode,
            $city,
            $address,
            $fee,
            $state,
            $grossAmount
        );
    }

    /**
     * @param PayPalIpnEntity $ipnEntity
     *
     * @return PayPalIpn
     */
    public function createFromIpnEntity(PayPalIpnEntity $ipnEntity): PayPalIpn
    {
        return $this->createFromArray($ipnEntity->getSalesMessage()->getRawPayPalData());
    }

    /**
     * @param array $rawPayPalData
     *
     * @return bool
     */
    private function checkIsSandbox(array $rawPayPalData): bool
    {
        return
            array_key_exists('test_ipn', $rawPayPalData)
            && $rawPayPalData['test_ipn'] == 1;
    }

    /**
     * @param array $rawPayPalData
     *
     * @return IpnType
     */
    private function getIpnType(array $rawPayPalData): IpnType
    {
        if ($this->isEbay($rawPayPalData)) {
            return new IpnType(IpnType::TYPE_PAYPAL_EBAY);
        }

        if (
            array_key_exists('txn_type', $rawPayPalData)
            && $rawPayPalData['txn_type'] == 'web_accept'
        ) {
            return new IpnType(IpnType::TYPE_PAYPAL_WEB);
        }

        return new IpnType(IpnType::TYPE_PAYPAL_OTHER);
    }

    /**
     * @param array $rawPayPalData
     *
     * @return bool
     */
    private function isEbay(array $rawPayPalData): bool
    {
        if (array_key_exists('auction_buyer_id', $rawPayPalData))
        {
            return true;
        }

        return (
            array_key_exists('txn_type', $rawPayPalData)
            && $rawPayPalData['txn_type'] == 'cart'
            && array_key_exists('num_cart_items', $rawPayPalData)
        );
    }
}
