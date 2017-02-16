<?php

namespace LaraCall\Domain\Services;

use DateTimeInterface;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\ValueObjects\BillingInfo;
use LaraCall\Domain\ValueObjects\BuyerInfo;
use LaraCall\Domain\ValueObjects\PaymentTransaction;
use LaraCall\Domain\ValueObjects\ShippingInfo;
use LaraCall\Domain\ValueObjects\PaymentStatus;

interface PaymentProcessorInterface
{
    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function isPaymentFraud($data): bool;

    /**
     * @param $data
     *
     * @return string
     */
    public function getExternalUserId($data): string ;

    /**
     * @param mixed $uniqueUserId
     *
     * @return Subscription|null
     */
    public function getReturningUserSubscription(string $uniqueUserId): ?Subscription;

    /**
     * @param Subscription       $subscriptionEntity
     * @param string             $uniqueUserId
     * @param                    $data
     *
     * @return void
     */
    public function storeCustomer(Subscription $subscriptionEntity, string $uniqueUserId, $data);

    /**
     * @param $data
     *
     * @return PaymentStatus
     */
    public function getPaymentStatus($data): PaymentStatus;

    /**
     * @param $data
     *
     * @return array|PaymentTransaction[]
     */
    public function getPaymentTransactions($data): array;

    /**
     * @param $data
     *
     * @return BuyerInfo
     */
    public function getBuyerInfo($data): BuyerInfo;

    /**
     * @return BillingInfo
     */
    public function getBillingInfo(): BillingInfo;

    /**
     * @return ShippingInfo
     */
    public function getShippingInfo(): ShippingInfo;

    /**
     * @return string
     */
    public function getPaymentProcessorName(): string;

    /**
     * @return DateTimeInterface
     */
    public function getPaymentDate();
}
