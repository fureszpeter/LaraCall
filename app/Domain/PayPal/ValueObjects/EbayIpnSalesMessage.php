<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use UnexpectedValueException;

class EbayIpnSalesMessage extends ValidatedIpnSalesMessage
{
    /**
     * @param ValidatedIpnSalesMessage $ipnSalesMessage
     *
     * @throws UnexpectedValueException If IPN message is not an ebay IPN message.
     */
    public function __construct(ValidatedIpnSalesMessage $ipnSalesMessage)
    {
        parent::__construct($ipnSalesMessage->getRawPayPalData(), $ipnSalesMessage->isValid());

        if ( ! $this->isEbay()) {
            throw new UnexpectedValueException(
                'This is not an ebay message'
            );
        }
    }

    /**
     * @return PayPalIpnEbayTransactionDetails[]
     */
    public function getTransactions(): array
    {
        $transactions  = [];
        $rawPayPalData = $this->getRawPayPalData();

        for ($i = 1; $i <= $this->getNumberOfCartItems(); $i++) {
            $transactions[] = new PayPalIpnEbayTransactionDetails(
                new ItemId($rawPayPalData[sprintf('item_number%s', $i)]),
                $rawPayPalData[sprintf('ebay_txn_id%s', $i)],
                $rawPayPalData[sprintf('quantity%s', $i)],
                (string) $rawPayPalData[sprintf('mc_gross_%s', $i)],
                (string) $rawPayPalData['mc_currency']
            );
        }

        return $transactions;
    }

    /**
     * @return int
     */
    public function getNumberOfCartItems(): int
    {
        return $this->getRawPayPalData()['num_cart_items'];
    }

    /**
     * @return string
     */
    public function getEbayUserId(): string {
        return $this->getRawPayPalData()['auction_buyer_id'];
    }
}
