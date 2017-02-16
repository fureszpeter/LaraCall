<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

class ValidatedIpnSalesMessage extends IpnSalesMessage
{
    /**
     * @var bool
     */
    protected $valid;

    /**
     * @param array $rawPayPalData
     * @param bool  $valid
     */
    public function __construct(array $rawPayPalData, bool $valid)
    {
        parent::__construct($rawPayPalData);
        $this->valid = $valid;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }
}
