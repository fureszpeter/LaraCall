<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

use DateTimeImmutable;
use JsonSerializable;
use UnexpectedValueException;

class IpnSalesMessage implements JsonSerializable
{
    /**
     * @var array
     */
    private $rawPayPalData;

    /**
     * @var bool
     */
    private $isSandBox;

    /**
     * @param array $rawPayPalData
     *
     * @throws UnexpectedValueException If empty message is received.
     */
    public function __construct(array $rawPayPalData)
    {
        if (empty($rawPayPalData)) {
            throw new UnexpectedValueException('Empty IPN message not allowed for PayPal!');
        }

        $this->rawPayPalData = $rawPayPalData;
        $this->isSandBox     = (array_key_exists('test_ipn', $rawPayPalData) && $rawPayPalData['test_ipn'] == 1)
            ? true
            : false;
    }

    /**
     * @return bool
     */
    public function isSandBox(): bool
    {
        return $this->isSandBox;
    }

    /**
     * @return string
     */
    public function getTxnId(): string
    {
        return $this->getRawPayPalData()['txn_id'];
    }

    /**
     * @return array
     */
    public function getRawPayPalData(): array
    {
        return $this->rawPayPalData;
    }

    /**
     * @return string
     */
    public function getReceiverEmail(): string
    {
        return $this->getRawPayPalData()['receiver_email'];
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateOfTransaction(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->getRawPayPalData()['payment_date']);
    }

    /**
     * @return string
     */
    public function getPayerEmail(): string
    {
        return $this->getRawPayPalData()['payer_email'];
    }

    /**
     * @return null|string
     */
    public function getParentTxnId(): ?string
    {
        return array_key_exists('parent_txn_id', $this->getRawPayPalData())
            ? $this->getRawPayPalData()['parent_txn_id']
            : null;
    }

    /**
     * @return string
     */
    public function getPaymentStatus(): string
    {
        return $this->getRawPayPalData()['payment_status'];
    }

    /**
     * @return bool
     */
    public function isEbay(): bool
    {
        return (
            array_key_exists('txn_type', $this->rawPayPalData) &&
            $this->rawPayPalData['txn_type'] == 'cart'
            && array_key_exists('num_cart_items', $this->rawPayPalData)
        );
    }

    /**
     * @return string|null
     */
    public function getCustomField(): ?string
    {
        return $this->hasCustomField()
            ? $this->rawPayPalData['custom']
            : null;
    }

    /**
     * @return bool
     */
    public function hasCustomField(): bool
    {
        return array_key_exists('custom', $this->rawPayPalData);
    }

    /**
     * @return float
     */
    public function getGrossAmount()
    {
        return floatval($this->getRawPayPalData()['payment_gross']);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getRawPayPalData();
    }
}

/*
 *  [
            'mc_gross'               => '11.24',
            'protection_eligibility' => 'Eligible',
            'for_auction'            => 'true',
            'address_status'         => 'confirmed',
            'item_number1'           => '111385463106',
            'tax'                    => '0.74',
            'payer_id'               => 'NHMEQCAQNV4VJ',
            'ebay_txn_id1'           => '1596375067001',
            'address_street'         => '120 Lake Carol Dr',
            'payment_date'           => '15:08:49 Dec 02, 2016 PST',
            'payment_status'         => 'Completed',
            'charset'                => 'UTF-8',
            'address_zip'            => '33411-2360',
            'mc_shipping'            => '0.00',
            'first_name'             => 'Rafael',
            'mc_fee'                 => '0.61',
            'auction_buyer_id'       => 'radiwa',
            'address_country_code'   => 'US',
            'address_name'           => 'R A Dietsch',
            'notify_version'         => '3.8',
            'custom'                 => 'EBAY_EMSCX0000693467341012',
            'payer_status'           => 'verified',
            'business'               => 'itctflorida@gmail.com',
            'address_country'        => 'United States',
            'num_cart_items'         => '1',
            'address_city'           => 'Royal Palm Beach',
            'verify_sign'            => 'Avil5zNgI4a7bYWDidXv4.tc0t6NAdXK14ftSEuNDZrfS-6HXDMG7jNC',
            'payer_email'            => 'radiwastore@gmail.com',
            'txn_id'                 => '0KE95881ED620491S',
            'payment_type'           => 'instant',
            'payer_business_name'    => 'Radiwa Store',
            'last_name'              => 'Dietsch',
            'address_state'          => 'FL',
            'item_name1'             => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
            'receiver_email'         => 'itctflorida@gmail.com',
            'payment_fee'            => '0.61',
            'quantity1'              => '3',
            'insurance_amount'       => '0.00',
            'receiver_id'            => 'TNPCXAZWPE9YN',
            'txn_type'               => 'cart',
            'item_name'              => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
            'mc_gross_1'             => '10.50',
            'mc_currency'            => 'USD',
            'item_number'            => '111385463106',
            'residence_country'      => 'US',
            'transaction_subject'    => '',
            'payment_gross'          => '11.24',
            'ipn_track_id'           => '3ad600e1c82f7',
        ];
 */


/*
 * 1 db
 */
//[
//    "mc_gross"               => "4.49",
//    "protection_eligibility" => "Eligible",
//    "for_auction"            => "true",
//    "address_status"         => "confirmed",
//    "item_number1"           => "111385463106",
//    "tax"                    => "0.00",
//    "payer_id"               => "FQZQXNHUXMDKG",
//    "ebay_txn_id1"           => "1598664684001",
//    "address_street"         => "324 Rutledge Ave.",
//    "payment_date"           => "06:38:23 Dec 07, 2016 PST",
//    "payment_status"         => "Completed",
//    "charset"                => "UTF-8",
//    "address_zip"            => "19033",
//    "mc_shipping"            => "0.00",
//    "first_name"             => "chona",
//    "mc_fee"                 => "0.27",
//    "auction_buyer_id"       => "chonac2007",
//    "address_country_code"   => "US",
//    "address_name"           => "chona coronel",
//    "notify_version"         => "3.8",
//    "custom"                 => "EBAY_EMSCX0000693122344115",
//    "payer_status"           => "verified",
//    "business"               => "itctflorida@gmail.com",
//    "address_country"        => "United States",
//    "num_cart_items"         => "1",
//    "address_city"           => "Folsom",
//    "verify_sign"            => "APclMDPdWaSSAOtbaJrWk-DEAcR8AkO5sOSINlsuDHK-SQJhFI.6f7ad",
//    "payer_email"            => "chona_coronel77@yahoo.com",
//    "txn_id"                 => "0EN063059J122402S",
//    "payment_type"           => "instant",
//    "last_name"              => "coronel",
//    "address_state"          => "PA",
//    "item_name1"             => "Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!",
//    "receiver_email"         => "itctflorida@gmail.com",
//    "payment_fee"            => "0.27",
//    "quantity1"              => "1",
//    "receiver_id"            => "TNPCXAZWPE9YN",
//    "insurance_amount"       => "0.00",
//    "txn_type"               => "cart",
//    "item_name"              => "Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!",
//    "mc_gross_1"             => "4.49",
//    "mc_currency"            => "USD",
//    "item_number"            => "111385463106",
//    "residence_country"      => "US",
//    "transaction_subject"    => "",
//    "payment_gross"          => "4.49",
//    "ipn_track_id"           => "a557155962f93",
//];
//
///*
// * 3 db
// */
//[
//    'mc_gross'               => '11.24',
//    'protection_eligibility' => 'Eligible',
//    'for_auction'            => 'true',
//    'address_status'         => 'confirmed',
//    'item_number1'           => '111385463106',
//    'tax'                    => '0.74',
//    'payer_id'               => 'NHMEQCAQNV4VJ',
//    'ebay_txn_id1'           => '1596375067001',
//    'address_street'         => '120 Lake Carol Dr',
//    'payment_date'           => '15:08:49 Dec 02, 2016 PST',
//    'payment_status'         => 'Completed',
//    'charset'                => 'UTF-8',
//    'address_zip'            => '33411-2360',
//    'mc_shipping'            => '0.00',
//    'first_name'             => 'Rafael',
//    'mc_fee'                 => '0.61',
//    'auction_buyer_id'       => 'radiwa',
//    'address_country_code'   => 'US',
//    'address_name'           => 'R A Dietsch',
//    'notify_version'         => '3.8',
//    'custom'                 => 'EBAY_EMSCX0000693467341012',
//    'payer_status'           => 'verified',
//    'business'               => 'itctflorida@gmail.com',
//    'address_country'        => 'United States',
//    'num_cart_items'         => '1',
//    'address_city'           => 'Royal Palm Beach',
//    'verify_sign'            => 'Avil5zNgI4a7bYWDidXv4.tc0t6NAdXK14ftSEuNDZrfS-6HXDMG7jNC',
//    'payer_email'            => 'radiwastore@gmail.com',
//    'txn_id'                 => '0KE95881ED620491S',
//    'payment_type'           => 'instant',
//    'payer_business_name'    => 'Radiwa Store',
//    'last_name'              => 'Dietsch',
//    'address_state'          => 'FL',
//    'item_name1'             => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'receiver_email'         => 'itctflorida@gmail.com',
//    'payment_fee'            => '0.61',
//    'quantity1'              => '3',
//    'insurance_amount'       => '0.00',
//    'receiver_id'            => 'TNPCXAZWPE9YN',
//    'txn_type'               => 'cart',
//    'item_name'              => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'mc_gross_1'             => '10.50',
//    'mc_currency'            => 'USD',
//    'item_number'            => '111385463106',
//    'residence_country'      => 'US',
//    'transaction_subject'    => '',
//    'payment_gross'          => '11.24',
//    'ipn_track_id'           => '3ad600e1c82f7',
//];

//[
//    'transaction_subject'    => '',
//    'payment_date'           => '07:41:54 Dec 30, 2016 PST',
//    'txn_type'               => 'web_accept',
//    'last_name'              => 'colletti',
//    'residence_country'      => 'US',
//    'item_name'              => 'Voice Credit',
//    'payment_gross'          => '10.00',
//    'mc_currency'            => 'USD',
//    'business'               => 'itctflorida@gmail.com',
//    'payment_type'           => 'instant',
//    'protection_eligibility' => 'Ineligible',
//    'verify_sign'            => 'AZEgj0Cs3KnvppEIazRuPtz9xZYTA-tTSx5gqLkbMJ.IbqW2O0wBNtzR',
//    'payer_status'           => 'verified',
//    'payer_email'            => 'pc.jhcc@yahoo.com',
//    'txn_id'                 => '1L531927US8089325',
//    'quantity'               => '1',
//    'receiver_email'         => 'itctflorida@gmail.com',
//    'first_name'             => 'peter',
//    'payer_id'               => 'LSL79VCVSQH3C',
//    'receiver_id'            => 'TNPCXAZWPE9YN',
//    'item_number'            => 0,
//    'payment_status'         => 'Completed',
//    'payment_fee'            => '0.55',
//    'mc_fee'                 => '0.55',
//    'mc_gross'               => '10.00',
//    'custom'                 => '',
//    'charset'                => 'UTF-8',
//    'notify_version'         => '3.8',
//    'ipn_track_id'           => '5dc5b75abf23f',
//    'mc_gross_'              => '10.00',
//]

/*
 * Root IPN 88U5649028323845J
 */
//[
//    'mc_gross'               => '4.49',
//    'protection_eligibility' => 'Eligible',
//    'for_auction'            => 'true',
//    'address_status'         => 'confirmed',
//    'item_number1'           => '111385463106',
//    'tax'                    => '0.00',
//    'payer_id'               => 'KHRMKHH7FTGHQ',
//    'ebay_txn_id1'           => '1603597317001',
//    'address_street'         => '625 Liberty Ave EQT plaza - AON - 10th floor',
//    'payment_date'           => '20:48:36 Dec 17, 2016 PST',
//    'payment_status'         => 'Completed',
//    'charset'                => 'UTF-8',
//    'address_zip'            => '15222-3110',
//    'mc_shipping'            => '0.00',
//    'first_name'             => 'terri',
//    'mc_fee'                 => '0.27',
//    'auction_buyer_id'       => 'zipper95',
//    'address_country_code'   => 'US',
//    'address_name'           => 'Terri L Hamilton',
//    'notify_version'         => '3.8',
//    'custom'                 => 'EBAY_EMSCX0000695518286311',
//    'payer_status'           => 'verified',
//    'business'               => 'itctflorida@gmail.com',
//    'address_country'        => 'United States',
//    'num_cart_items'         => '1',
//    'address_city'           => 'Pittsburgh',
//    'verify_sign'            => 'A5jg5FHbO3aWQKHd4A60fQrDAEioApeBJh3UrUCMnXSpJVnL.-WS32dK',
//    'payer_email'            => 'bluegoose95@hotmail.com',
//    'txn_id'                 => '88U5649028323845J',
//    'payment_type'           => 'instant',
//    'last_name'              => 'hamilton',
//    'address_state'          => 'PA',
//    'item_name1'             => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'receiver_email'         => 'itctflorida@gmail.com',
//    'payment_fee'            => '0.27',
//    'quantity1'              => '1',
//    'receiver_id'            => 'TNPCXAZWPE9YN',
//    'insurance_amount'       => '0.00',
//    'txn_type'               => 'cart',
//    'item_name'              => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'mc_gross_1'             => '4.49',
//    'mc_currency'            => 'USD',
//    'item_number'            => '111385463106',
//    'residence_country'      => 'US',
//    'transaction_subject'    => '',
//    'payment_gross'          => '4.49',
//    'ipn_track_id'           => '8663b3f2c689d',
//]

/*
 * Child of 88U5649028323845J
 * Ipn: 1PK24584YL634650N
 */
//[
//    'mc_gross'               => '-4.22',
//    'protection_eligibility' => 'Eligible',
//    'item_number1'           => '111385463106',
//    'payer_id'               => 'KHRMKHH7FTGHQ',
//    'ebay_txn_id1'           => '1603597317001',
//    'address_street'         => '625 Liberty Ave EQT plaza - AON - 10th floor',
//    'payment_date'           => '04:44:31 Dec 19, 2016 PST',
//    'payment_status'         => 'Reversed',
//    'charset'                => 'UTF-8',
//    'address_zip'            => '15222-3110',
//    'mc_shipping'            => '0.00',
//    'mc_handling'            => '0.00',
//    'first_name'             => 'terri',
//    'mc_fee'                 => '-0.27',
//    'auction_buyer_id'       => 'zipper95',
//    'address_country_code'   => 'US',
//    'address_name'           => 'Terri L Hamilton',
//    'notify_version'         => '3.8',
//    'reason_code'            => 'unauthorized_claim',
//    'custom'                 => 'EBAY_EMSCX0000695518286311',
//    'business'               => 'itctflorida@gmail.com',
//    'address_country'        => 'United States',
//    'mc_handling1'           => '0.00',
//    'address_city'           => 'Pittsburgh',
//    'verify_sign'            => 'AlObED.2c.sLLAH84Jr8bZje3vwSAN.avMwYdZWjVvncmS-y3Ie1.E-9',
//    'mc_shipping1'           => '0.00',
//    'payer_email'            => 'bluegoose95@hotmail.com',
//    'tax1'                   => '0.00',
//    'parent_txn_id'          => '88U5649028323845J',
//    'txn_id'                 => '1PK24584YL634650N',
//    'payment_type'           => 'instant',
//    'last_name'              => 'hamilton',
//    'address_state'          => 'PA',
//    'item_name1'             => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'receiver_email'         => 'itctflorida@gmail.com',
//    'payment_fee'            => '-0.27',
//    'shipping_discount'      => '0.00',
//    'quantity1'              => '1',
//    'receiver_id'            => 'TNPCXAZWPE9YN',
//    'insurance_amount'       => '0.00',
//    'item_name'              => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'discount'               => '0.00',
//    'mc_gross_1'             => '4.49',
//    'mc_currency'            => 'USD',
//    'item_number'            => '111385463106',
//    'residence_country'      => 'US',
//    'shipping_method'        => 'Default',
//    'transaction_subject'    => '',
//    'payment_gross'          => '-4.22',
//    'ipn_track_id'           => 'e4a0202df09ad',
//]

/*
 * Child of: 88U5649028323845J
 * Ipn:  8MX6599309432990Y
 */
//[
//    'mc_gross'               => '-4.49',
//    'protection_eligibility' => 'Eligible',
//    'item_number1'           => '111385463106',
//    'payer_id'               => 'KHRMKHH7FTGHQ',
//    'ebay_txn_id1'           => '1603597317001',
//    'address_street'         => '625 Liberty Ave EQT plaza - AON - 10th floor',
//    'payment_date'           => '08:07:11 Dec 30, 2016 PST',
//    'payment_status'         => 'Reversed',
//    'charset'                => 'UTF-8',
//    'address_zip'            => '15222-3110',
//    'mc_shipping'            => '0.00',
//    'mc_handling'            => '0.00',
//    'first_name'             => 'terri',
//    'mc_fee'                 => '-0.27',
//    'auction_buyer_id'       => 'zipper95',
//    'address_country_code'   => 'US',
//    'address_name'           => 'Terri L Hamilton',
//    'notify_version'         => '3.8',
//    'reason_code'            => 'unauthorized_spoof',
//    'custom'                 => 'EBAY_EMSCX0000695518286311',
//    'business'               => 'itctflorida@gmail.com',
//    'address_country'        => 'United States',
//    'mc_handling1'           => '0.00',
//    'address_city'           => 'Pittsburgh',
//    'verify_sign'            => 'A9EwbxNCfqNC8PWq31G.JbRcLm4WAZ5ejWh3A70wdcSG3nXxWlJ3mnbK',
//    'mc_shipping1'           => '0.00',
//    'payer_email'            => 'bluegoose95@hotmail.com',
//    'tax1'                   => '0.00',
//    'parent_txn_id'          => '88U5649028323845J',
//    'txn_id'                 => '8MX6599309432990Y',
//    'payment_type'           => 'instant',
//    'last_name'              => 'hamilton',
//    'address_state'          => 'PA',
//    'item_name1'             => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'receiver_email'         => 'itctflorida@gmail.com',
//    'payment_fee'            => '-0.27',
//    'shipping_discount'      => '0.00',
//    'quantity1'              => '1',
//    'receiver_id'            => 'TNPCXAZWPE9YN',
//    'insurance_amount'       => '0.00',
//    'item_name'              => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'discount'               => '0.00',
//    'mc_gross_1'             => '4.49',
//    'mc_currency'            => 'USD',
//    'item_number'            => '111385463106',
//    'residence_country'      => 'US',
//    'shipping_method'        => 'Default',
//    'transaction_subject'    => '',
//    'payment_gross'          => '-4.49',
//    'ipn_track_id'           => 'dcbb0461bdedb',
//]

/*
 * Parent: 88U5649028323845J
 * Ipn: 1PK24584YL634650N
 */
//[
//    'mc_gross'               => '4.22',
//    'protection_eligibility' => 'Eligible',
//    'item_number1'           => '111385463106',
//    'payer_id'               => 'KHRMKHH7FTGHQ',
//    'ebay_txn_id1'           => '1603597317001',
//    'address_street'         => '625 Liberty Ave EQT plaza - AON - 10th floor',
//    'payment_date'           => '04:44:31 Dec 19, 2016 PST',
//    'payment_status'         => 'Canceled_Reversal',
//    'charset'                => 'UTF-8',
//    'address_zip'            => '15222-3110',
//    'mc_shipping'            => '0.00',
//    'mc_handling'            => '0.00',
//    'first_name'             => 'terri',
//    'mc_fee'                 => '0.27',
//    'auction_buyer_id'       => 'zipper95',
//    'address_country_code'   => 'US',
//    'address_name'           => 'Terri L Hamilton',
//    'notify_version'         => '3.8',
//    'reason_code'            => 'unauthorized_claim',
//    'custom'                 => 'EBAY_EMSCX0000695518286311',
//    'business'               => 'itctflorida@gmail.com',
//    'address_country'        => 'United States',
//    'mc_handling1'           => '0.00',
//    'address_city'           => 'Pittsburgh',
//    'verify_sign'            => 'AAJ8sHGjPsxLjCwiCHRzFxwimkULA8X3pO6-iOPulEn54ULoX6rMTQ5W',
//    'mc_shipping1'           => '0.00',
//    'payer_email'            => 'bluegoose95@hotmail.com',
//    'tax1'                   => '0.00',
//    'parent_txn_id'          => '88U5649028323845J',
//    'txn_id'                 => '1PK24584YL634650N',
//    'payment_type'           => 'instant',
//    'last_name'              => 'hamilton',
//    'address_state'          => 'PA',
//    'item_name1'             => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'receiver_email'         => 'itctflorida@gmail.com',
//    'payment_fee'            => '0.27',
//    'shipping_discount'      => '0.00',
//    'quantity1'              => '1',
//    'receiver_id'            => 'TNPCXAZWPE9YN',
//    'insurance_amount'       => '0.00',
//    'item_name'              => 'Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!',
//    'discount'               => '0.00',
//    'mc_gross_1'             => '4.49',
//    'mc_currency'            => 'USD',
//    'item_number'            => '111385463106',
//    'residence_country'      => 'US',
//    'shipping_method'        => 'Default',
//    'transaction_subject'    => '',
//    'payment_gross'          => '4.22',
//    'ipn_track_id'           => 'dcbb0461bdedb',
//]

/**
 * Web payment, not ebay
 */
//a:29:{s:19:"transaction_subject";s:0:"";s:12:"payment_date";s:25:"07:41:54 Dec 30, 2016 PST";s:8:"txn_type";s:10:"web_accept";s:9:"last_name";s:8:"colletti";s:17:"residence_country";s:2:"US";s:9:"item_name";s:12:"Voice Credit";s:13:"payment_gross";s:5:"10.00";s:11:"mc_currency";s:3:"USD";s:8:"business";s:21:"itctflorida@gmail.com";s:12:"payment_type";s:7:"instant";s:22:"protection_eligibility";s:10:"Ineligible";s:11:"verify_sign";s:56:"AZEgj0Cs3KnvppEIazRuPtz9xZYTA-tTSx5gqLkbMJ.IbqW2O0wBNtzR";s:12:"payer_status";s:8:"verified";s:11:"payer_email";s:17:"pc.jhcc@yahoo.com";s:6:"txn_id";s:17:"1L531927US8089325";s:8:"quantity";s:1:"1";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:10:"first_name";s:5:"peter";s:8:"payer_id";s:13:"LSL79VCVSQH3C";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:11:"item_number";s:0:"";s:14:"payment_status";s:9:"Completed";s:11:"payment_fee";s:4:"0.55";s:6:"mc_fee";s:4:"0.55";s:8:"mc_gross";s:5:"10.00";s:6:"custom";s:0:"";s:7:"charset";s:5:"UTF-8";s:14:"notify_version";s:3:"3.8";s:12:"ipn_track_id";s:13:"5dc5b75abf23f";}

//[
//    'transaction_subject'    => '',
//    'payment_date'           => '07:41:54 Dec 30, 2016 PST',
//    'txn_type'               => 'web_accept',
//    'last_name'              => 'colletti',
//    'residence_country'      => 'US',
//    'item_name'              => 'Voice Credit',
//    'payment_gross'          => '10.00',
//    'mc_currency'            => 'USD',
//    'business'               => 'itctflorida@gmail.com',
//    'payment_type'           => 'instant',
//    'protection_eligibility' => 'Ineligible',
//    'verify_sign'            => 'AZEgj0Cs3KnvppEIazRuPtz9xZYTA-tTSx5gqLkbMJ.IbqW2O0wBNtzR',
//    'payer_status'           => 'verified',
//    'payer_email'            => 'pc.jhcc@yahoo.com',
//    'txn_id'                 => '1L531927US8089325',
//    'quantity'               => '1',
//    'receiver_email'         => 'itctflorida@gmail.com',
//    'first_name'             => 'peter',
//    'payer_id'               => 'LSL79VCVSQH3C',
//    'receiver_id'            => 'TNPCXAZWPE9YN',
//    'item_number'            => '',
//    'payment_status'         => 'Completed',
//    'payment_fee'            => '0.55',
//    'mc_fee'                 => '0.55',
//    'mc_gross'               => '10.00',
//    'custom'                 => '',
//    'charset'                => 'UTF-8',
//    'notify_version'         => '3.8',
//    'ipn_track_id'           => '5dc5b75abf23f',
//]
