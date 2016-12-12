<?php

namespace LaraCall\Http\Controllers;

use Illuminate\Http\Request;

use LaraCall\Http\Requests;

class IpnController extends Controller
{
    public function payPalIpn()
    {
        $serialized = 'a:48:{s:8:"mc_gross";s:5:"11.24";s:22:"protection_eligibility";s:8:"Eligible";s:11:"for_auction";s:4:"true";s:14:"address_status";s:9:"confirmed";s:12:"item_number1";s:12:"111385463106";s:3:"tax";s:4:"0.74";s:8:"payer_id";s:13:"NHMEQCAQNV4VJ";s:12:"ebay_txn_id1";s:13:"1596375067001";s:14:"address_street";s:17:"120 Lake Carol Dr";s:12:"payment_date";s:25:"15:08:49 Dec 02, 2016 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:10:"33411-2360";s:11:"mc_shipping";s:4:"0.00";s:10:"first_name";s:6:"Rafael";s:6:"mc_fee";s:4:"0.61";s:16:"auction_buyer_id";s:6:"radiwa";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:11:"R A Dietsch";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:26:"EBAY_EMSCX0000693467341012";s:12:"payer_status";s:8:"verified";s:8:"business";s:21:"itctflorida@gmail.com";s:15:"address_country";s:13:"United States";s:14:"num_cart_items";s:1:"1";s:12:"address_city";s:16:"Royal Palm Beach";s:11:"verify_sign";s:56:"Avil5zNgI4a7bYWDidXv4.tc0t6NAdXK14ftSEuNDZrfS-6HXDMG7jNC";s:11:"payer_email";s:21:"radiwastore@gmail.com";s:6:"txn_id";s:17:"0KE95881ED620491S";s:12:"payment_type";s:7:"instant";s:19:"payer_business_name";s:12:"Radiwa Store";s:9:"last_name";s:7:"Dietsch";s:13:"address_state";s:2:"FL";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:11:"payment_fee";s:4:"0.61";s:9:"quantity1";s:1:"3";s:16:"insurance_amount";s:4:"0.00";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:8:"txn_type";s:4:"cart";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:10:"mc_gross_1";s:5:"10.50";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:12:"111385463106";s:17:"residence_country";s:2:"US";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:5:"11.24";s:12:"ipn_track_id";s:13:"3ad600e1c82f7";}';

        $ipn = unserialize($serialized);

        dd(var_export($ipn));
        /*
         * 1 db
         */
        [
            "mc_gross"               => "4.49",
            "protection_eligibility" => "Eligible",
            "for_auction"            => "true",
            "address_status"         => "confirmed",
            "item_number1"           => "111385463106",
            "tax"                    => "0.00",
            "payer_id"               => "FQZQXNHUXMDKG",
            "ebay_txn_id1"           => "1598664684001",
            "address_street"         => "324 Rutledge Ave.",
            "payment_date"           => "06:38:23 Dec 07, 2016 PST",
            "payment_status"         => "Completed",
            "charset"                => "UTF-8",
            "address_zip"            => "19033",
            "mc_shipping"            => "0.00",
            "first_name"             => "chona",
            "mc_fee"                 => "0.27",
            "auction_buyer_id"       => "chonac2007",
            "address_country_code"   => "US",
            "address_name"           => "chona coronel",
            "notify_version"         => "3.8",
            "custom"                 => "EBAY_EMSCX0000693122344115",
            "payer_status"           => "verified",
            "business"               => "itctflorida@gmail.com",
            "address_country"        => "United States",
            "num_cart_items"         => "1",
            "address_city"           => "Folsom",
            "verify_sign"            => "APclMDPdWaSSAOtbaJrWk-DEAcR8AkO5sOSINlsuDHK-SQJhFI.6f7ad",
            "payer_email"            => "chona_coronel77@yahoo.com",
            "txn_id"                 => "0EN063059J122402S",
            "payment_type"           => "instant",
            "last_name"              => "coronel",
            "address_state"          => "PA",
            "item_name1"             => "Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!",
            "receiver_email"         => "itctflorida@gmail.com",
            "payment_fee"            => "0.27",
            "quantity1"              => "1",
            "receiver_id"            => "TNPCXAZWPE9YN",
            "insurance_amount"       => "0.00",
            "txn_type"               => "cart",
            "item_name"              => "Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!",
            "mc_gross_1"             => "4.49",
            "mc_currency"            => "USD",
            "item_number"            => "111385463106",
            "residence_country"      => "US",
            "transaction_subject"    => "",
            "payment_gross"          => "4.49",
            "ipn_track_id"           => "a557155962f93",
        ];

        /*
         * 3 db
         */
        [
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
        echo "I'm processing IPN message now...";
    }
}
