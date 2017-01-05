<?php
namespace LaraCall\Domain\PayPal\ValueObjects;

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
     * @return array
     */
    public function getRawPayPalData(): array
    {
        return $this->rawPayPalData;
    }

    /**
     * @return bool
     */
    public function isSandBox(): bool
    {
        return $this->isSandBox;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
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
