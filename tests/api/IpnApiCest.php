<?php


use LaraCall\Domain\PayPal\FalsePayPalIpnValidator;
use LaraCall\Domain\PayPal\PayPalIpnValidator;
use LaraCall\Domain\PayPal\TruePayPalIpnValidator;
use LaraCall\Domain\ValueObjects\IpnStatus;
use LaraCall\Domain\ValueObjects\PaymentStatus;
use LaraCall\Events\IpnStoredToQueueEvent;
use LaraCall\Events\PayPalIpnEntityCreatedEvent;

class IpnApiCest
{
    public function _before(ApiTester $I)
    {
        $I->runSqlQueries('functional/ipn_seed');
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     * @param string    $paymenStatus
     */
    private function canReceiveIpnMessage(ApiTester $I, $paymenStatus = PaymentStatus::STATUS_COMPLETED)
    {
        $data = [
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
            'payment_status'         => $paymenStatus,
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

        $I->sendPOST('api/paypal/ipn', $data);
        $I->seeResponseCodeIs(200);
        $I->canSeeEventTriggered(IpnStoredToQueueEvent::class);
    }

    /**
     * @param ApiTester $I
     */
    public function testIpnReceivedFromPayPal(ApiTester $I)
    {
        $I->wantTo('Test that can receive IPN message from PayPal');

        $I->getApplication()->singleton(PayPalIpnValidator::class, TruePayPalIpnValidator::class);

        $this->canReceiveIpnMessage($I);
        $I->canSeeEventTriggered(PayPalIpnEntityCreatedEvent::class);

        $I->canSeeInDatabase('pay_pal_ipns', [
            'txn_id' => '0KE95881ED620491S',
            'is_ebay' => 1,
            'process_count' => 0,
            'ebay_username' => 'radiwa',
            'status' => IpnStatus::STATUS_UNPROCESSED
        ]);

        $I->canSeeInDatabase('ipn_queues', ['is_pay_pal_the_sender' => 1, 'try_count' => 1]);

        $I->canSeeInDatabase('pay_pal_ipns', [
            'txn_id' => '0KE95881ED620491S',
            'is_ebay' => 1,
            'process_count' => 0,
            'ebay_username' => 'radiwa',
            'status' => IpnStatus::STATUS_UNPROCESSED
        ]);
    }



    public function testFakeSenderSendIpnMessage(ApiTester $I)
    {
        $I->wantTo('Test that can handle fake IPN sender');

        $I->getApplication()->singleton(PayPalIpnValidator::class, FalsePayPalIpnValidator::class);

        $this->canReceiveIpnMessage($I);

        $I->dontSeeEventTriggered(PayPalIpnEntityCreatedEvent::class);

        $I->canSeeInDatabase('ipn_queues', ['is_pay_pal_the_sender' => 0, 'try_count' => 1]);

        $I->dontSeeInDatabase('pay_pal_ipns', ['txn_id' => '0KE95881ED620491S']);
    }
}
