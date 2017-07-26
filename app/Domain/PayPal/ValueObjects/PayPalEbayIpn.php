<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

use LaraCall\Infrastructure\Services\Ebay\ValueObjects\ItemId;
use UnexpectedValueException;

class PayPalEbayIpn extends ValidatedPayPalIpn
{
    /** @var int */
    protected $numberOfCartItems;

    /**
     * @var PayPalIpnEbayTransaction[]
     */
    protected $transactionDetails = [];

    /** @var string */
    protected $ebayUserId;

    /**
     * @param ValidatedPayPalIpn $ipnSalesMessage
     *
     * @throws UnexpectedValueException If IPN message is not an ebay IPN message.
     */
    public function __construct(ValidatedPayPalIpn $ipnSalesMessage)
    {
        parent::__construct($ipnSalesMessage->getRawPayPalData(), $ipnSalesMessage->isValid());

        if ( ! $this->isEbay()) {
            throw new UnexpectedValueException(
                'This is not an ebay message'
            );
        }

        $this->setTransactionsDetails();
        $this->numberOfCartItems = $this->getRawPayPalData()['num_cart_items'];
        $this->ebayUserId        = $this->getRawPayPalData()['auction_buyer_id'];
    }

    private function setTransactionsDetails()
    {
        $rawPayPalData = $this->getRawPayPalData();

        for ($i = 1; $i <= $rawPayPalData['num_cart_items']; $i++) {
            $this->transactionDetails[] = new PayPalIpnEbayTransaction(
                new ItemId($rawPayPalData[sprintf('item_number%s', $i)]),
                $rawPayPalData['item_name' . $i],
                $rawPayPalData[sprintf('ebay_txn_id%s', $i)],
                $rawPayPalData[sprintf('quantity%s', $i)],
                (string) $rawPayPalData[sprintf('mc_gross_%s', $i)],
                (string) $rawPayPalData['mc_currency']
            );
        }
    }

    /**
     * @return int
     */
    public function getNumberOfCartItems(): int
    {
        return $this->numberOfCartItems;
    }

    /**
     * @return PayPalIpnEbayTransaction[]
     */
    public function getEbayTransactions(): array
    {
        return $this->transactionDetails;
    }

    /**
     * @param string $ebayUserId
     */
    public function setEbayUserId(string $ebayUserId)
    {
        $this->ebayUserId = $ebayUserId;
    }

    /**
     * @return string
     */
    public function getEbayUserId(): string
    {
        return $this->ebayUserId;
    }

}
