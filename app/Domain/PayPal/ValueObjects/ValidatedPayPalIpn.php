<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

class ValidatedPayPalIpn extends PayPalIpn
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
