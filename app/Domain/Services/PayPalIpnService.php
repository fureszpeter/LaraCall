<?php
namespace LaraCall\Domain\Services;

use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\PayPal\ValueObjects\ValidatedIpnSalesMessage;
use LaraCall\Domain\ValueObjects\IpnType;
use LaraCall\Domain\ValueObjects\PaymentStatus;

interface PayPalIpnService
{
    public function getIpnType(ValidatedIpnSalesMessage $ipnSalesMessage): IpnType;

    public function isValid(PayPalIpn $ipnEntity): bool;

    public function getPaymentStatus(ValidatedIpnSalesMessage $ipnSalesMessage): PaymentStatus;
}
