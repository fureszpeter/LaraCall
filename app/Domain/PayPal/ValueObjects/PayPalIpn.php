<?php

namespace LaraCall\Domain\PayPal\ValueObjects;

use DateTimeImmutable;
use JsonSerializable;
use LaraCall\Domain\ValueObjects\IpnType;
use LaraCall\Domain\ValueObjects\PaymentStatus;
use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;

class PayPalIpn implements JsonSerializable
{
    /** @var array */
    protected $rawPayPalData;

    /** @var bool */
    protected $isSandBox;

    /** @var string */
    protected $txnId;

    /** @var string|null */
    protected $parentTxnId;

    /** @var string */
    protected $receiverEmail;

    /** @var string */
    protected $payerEmail;

    /** @var DateTimeImmutable */
    protected $dateOfTransaction;

    /** @var PaymentStatus */
    protected $paymentStatus;

    /** @var bool */
    protected $isEbay;

    /** @var string|null */
    protected $customField;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $countryCode;

    /** @var string|null */
    protected $zipCode;

    /** @var string|null */
    protected $city;

    /** @var string|null */
    protected $address;

    /** @var float */
    protected $fee;

    /** @var string|null */
    protected $state;

    /** @var float */
    protected $grossAmount;

    /** @var EbayTransaction[] */
    protected $ebayTransactions = [];

    /** @var int|null */
    protected $numberOfCartItems;

    /** @var string|null */
    protected $ebayUserId;

    /** @var IpnType */
    private $ipnType;

    /**
     * @param array             $rawPayPalData
     * @param IpnType           $ipnType
     * @param bool              $isSandBox
     * @param string            $txnId
     * @param null|string       $parentTxnId
     * @param string            $receiverEmail
     * @param string            $payerEmail
     * @param DateTimeImmutable $dateOfTransaction
     * @param PaymentStatus     $paymentStatus
     * @param bool              $isEbay
     * @param null|string       $customField
     * @param string            $firstName
     * @param string            $lastName
     * @param string            $countryCode
     * @param null|string       $zipCode
     * @param null|string       $city
     * @param null|string       $address
     * @param float             $fee
     * @param null|string       $state
     * @param float             $grossAmount
     */
    public function __construct(
        array $rawPayPalData,
        IpnType $ipnType,
        bool $isSandBox,
        string $txnId,
        ?string $parentTxnId,
        string $receiverEmail,
        string $payerEmail,
        DateTimeImmutable $dateOfTransaction,
        PaymentStatus $paymentStatus,
        bool $isEbay,
        ?string $customField,
        string $firstName,
        string $lastName,
        ?string $countryCode,
        ?string $zipCode,
        ?string $city,
        ?string $address,
        float $fee,
        ?string $state,
        float $grossAmount
    ) {
        $this->rawPayPalData     = $rawPayPalData;
        $this->isSandBox         = $isSandBox;
        $this->txnId             = $txnId;
        $this->parentTxnId       = $parentTxnId;
        $this->receiverEmail     = $receiverEmail;
        $this->payerEmail        = $payerEmail;
        $this->dateOfTransaction = $dateOfTransaction;
        $this->paymentStatus     = $paymentStatus;
        $this->isEbay            = $isEbay;
        $this->customField       = $customField;
        $this->firstName         = $firstName;
        $this->lastName          = $lastName;
        $this->countryCode       = $countryCode;
        $this->zipCode           = $zipCode;
        $this->city              = $city;
        $this->address           = $address;
        $this->fee               = $fee;
        $this->state             = $state;
        $this->grossAmount       = $grossAmount;
        $this->ipnType           = $ipnType;

        if (
            true === $this->isEbay()
            && $paymentStatus->getStatus() === PaymentStatus::STATUS_COMPLETED
        ) {
            $this->setTransactionsDetails();

            $this->numberOfCartItems = $rawPayPalData['num_cart_items'];
            $this->ebayUserId        = $rawPayPalData['auction_buyer_id'];
        }
    }

    private function setTransactionsDetails()
    {
        $rawPayPalData = $this->getRawPayPalData();

        for ($i = 1; $i <= $rawPayPalData['num_cart_items']; $i++) {
            $this->ebayTransactions[] = new EbayTransaction(
                new ItemId($rawPayPalData[sprintf('item_number%s', $i)]),
                $rawPayPalData['item_name' . $i],
                $rawPayPalData[sprintf('ebay_txn_id%s', $i)],
                $rawPayPalData[sprintf('quantity%s', $i)],
                (string)$rawPayPalData[sprintf('mc_gross_%s', $i)],
                (string)$rawPayPalData['mc_currency']
            );
        }
    }

    /**
     * @return bool
     */
    public function isSandBox(): bool
    {
        return $this->isSandBox;
    }

    /**
     * @return IpnType
     */
    public function getIpnType(): IpnType
    {
        return $this->ipnType;
    }

    /**
     * @return string
     */
    public function getTxnId(): string
    {
        return $this->txnId;
    }

    /**
     * @return string
     */
    public function getReceiverEmail(): string
    {
        return $this->receiverEmail;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateOfTransaction(): DateTimeImmutable
    {
        return $this->dateOfTransaction;
    }

    /**
     * @return string
     */
    public function getPayerEmail(): string
    {
        return $this->payerEmail;
    }

    /**
     * @return null|string
     */
    public function getParentTxnId(): ?string
    {
        return $this->parentTxnId;
    }

    /**
     * @return PaymentStatus
     */
    public function getPaymentStatus(): PaymentStatus
    {
        return $this->paymentStatus;
    }

    /**
     * @return bool
     */
    public function isEbay(): bool
    {
        return $this->isEbay;
    }

    /**
     * @return bool
     */
    public function hasCustomField(): bool
    {
        return is_null($this->getCustomField());
    }

    /**
     * @return string|null
     */
    public function getCustomField(): ?string
    {
        return $this->customField;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return null|string
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @return null|string
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return float
     */
    public function getFee(): float
    {
        return $this->fee;
    }

    /**
     * @return null|string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @return float
     */
    public function getGrossAmount()
    {
        return $this->grossAmount;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getRawPayPalData();
    }

    /**
     * @return array
     */
    public function getRawPayPalData(): array
    {
        return $this->rawPayPalData;
    }

    /**
     * @return EbayTransaction[]
     */
    public function getEbayTransactions(): array
    {
        return $this->ebayTransactions;
    }

    /**
     * @return int|null
     */
    public function getNumberOfCartItems(): ?int
    {
        return $this->numberOfCartItems;
    }

    /**
     * @return null|string
     */
    public function getEbayUserId(): ?string
    {
        return $this->ebayUserId;
    }

    /**
     * @param null|string $ebayUserId
     *
     * @return $this
     */
    public function setEbayUserId(?string $ebayUserId): PayPalIpn
    {
        $this->ebayUserId = $ebayUserId;

        return $this;
    }
}
