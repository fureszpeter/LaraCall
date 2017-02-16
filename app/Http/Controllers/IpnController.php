<?php

namespace LaraCall\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use LaraCall\Domain\Entities\PayPalIpn;
use LaraCall\Domain\PayPal\PayPalIpnValidator;
use LaraCall\Domain\PayPal\ValueObjects\IpnSalesMessage;
use LaraCall\Domain\Repositories\PayPalIpnRepository;

/**
 * Class IpnController.
 *
 * @package LaraCall
 *
 * @license Proprietary
 */
class IpnController extends Controller
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var PayPalIpnValidator
     */
    private $payPalService;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var PayPalIpnRepository
     */
    private $ipnSalesMessageRepository;

    /**
     * @param Dispatcher          $dispatcher
     * @param PayPalIpnValidator  $payPalService
     * @param EntityManager       $em
     * @param PayPalIpnRepository $ipnSalesMessageRepository
     */
    public function __construct(
        Dispatcher $dispatcher,
        PayPalIpnValidator $payPalService,
        EntityManager $em,
        PayPalIpnRepository $ipnSalesMessageRepository

    ) {
        $this->dispatcher                = $dispatcher;
        $this->payPalService             = $payPalService;
        $this->em                        = $em;
        $this->ipnSalesMessageRepository = $ipnSalesMessageRepository;
    }

    /**
     * @param Request $request
     */
    public function payPalIpn(Request $request)
    {
//        $serialized = 'a:48:{s:8:"mc_gross";s:5:"11.24";s:22:"protection_eligibility";s:8:"Eligible";s:11:"for_auction";s:4:"true";s:14:"address_status";s:9:"confirmed";s:12:"item_number1";s:12:"111385463106";s:3:"tax";s:4:"0.74";s:8:"payer_id";s:13:"NHMEQCAQNV4VJ";s:12:"ebay_txn_id1";s:13:"1596375067001";s:14:"address_street";s:17:"120 Lake Carol Dr";s:12:"payment_date";s:25:"15:08:49 Dec 02, 2016 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:10:"33411-2360";s:11:"mc_shipping";s:4:"0.00";s:10:"first_name";s:6:"Rafael";s:6:"mc_fee";s:4:"0.61";s:16:"auction_buyer_id";s:6:"radiwa";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:11:"R A Dietsch";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:26:"EBAY_EMSCX0000693467341012";s:12:"payer_status";s:8:"verified";s:8:"business";s:21:"itctflorida@gmail.com";s:15:"address_country";s:13:"United States";s:14:"num_cart_items";s:1:"1";s:12:"address_city";s:16:"Royal Palm Beach";s:11:"verify_sign";s:56:"Avil5zNgI4a7bYWDidXv4.tc0t6NAdXK14ftSEuNDZrfS-6HXDMG7jNC";s:11:"payer_email";s:21:"radiwastore@gmail.com";s:6:"txn_id";s:17:"0KE95881ED620491S";s:12:"payment_type";s:7:"instant";s:19:"payer_business_name";s:12:"Radiwa Store";s:9:"last_name";s:7:"Dietsch";s:13:"address_state";s:2:"FL";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:11:"payment_fee";s:4:"0.61";s:9:"quantity1";s:1:"3";s:16:"insurance_amount";s:4:"0.00";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:8:"txn_type";s:4:"cart";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:10:"mc_gross_1";s:5:"10.50";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:12:"111385463106";s:17:"residence_country";s:2:"US";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:5:"11.24";s:12:"ipn_track_id";s:13:"3ad600e1c82f7";}';
        //Root ipn
//        $serialized = 'a:47:{s:8:"mc_gross";s:4:"4.49";s:22:"protection_eligibility";s:8:"Eligible";s:11:"for_auction";s:4:"true";s:14:"address_status";s:9:"confirmed";s:12:"item_number1";s:12:"111385463106";s:3:"tax";s:4:"0.00";s:8:"payer_id";s:13:"KHRMKHH7FTGHQ";s:12:"ebay_txn_id1";s:13:"1603597317001";s:14:"address_street";s:44:"625 Liberty Ave EQT plaza - AON - 10th floor";s:12:"payment_date";s:25:"20:48:36 Dec 17, 2016 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:10:"15222-3110";s:11:"mc_shipping";s:4:"0.00";s:10:"first_name";s:5:"terri";s:6:"mc_fee";s:4:"0.27";s:16:"auction_buyer_id";s:8:"zipper95";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:16:"Terri L Hamilton";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:26:"EBAY_EMSCX0000695518286311";s:12:"payer_status";s:8:"verified";s:8:"business";s:21:"itctflorida@gmail.com";s:15:"address_country";s:13:"United States";s:14:"num_cart_items";s:1:"1";s:12:"address_city";s:10:"Pittsburgh";s:11:"verify_sign";s:56:"A5jg5FHbO3aWQKHd4A60fQrDAEioApeBJh3UrUCMnXSpJVnL.-WS32dK";s:11:"payer_email";s:23:"bluegoose95@hotmail.com";s:6:"txn_id";s:17:"88U5649028323845J";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:8:"hamilton";s:13:"address_state";s:2:"PA";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:11:"payment_fee";s:4:"0.27";s:9:"quantity1";s:1:"1";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:16:"insurance_amount";s:4:"0.00";s:8:"txn_type";s:4:"cart";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:10:"mc_gross_1";s:4:"4.49";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:12:"111385463106";s:17:"residence_country";s:2:"US";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:4:"4.49";s:12:"ipn_track_id";s:13:"8663b3f2c689d";}';
//        $serialized = 'a:50:{s:8:"mc_gross";s:5:"-4.22";s:22:"protection_eligibility";s:8:"Eligible";s:12:"item_number1";s:12:"111385463106";s:8:"payer_id";s:13:"KHRMKHH7FTGHQ";s:12:"ebay_txn_id1";s:13:"1603597317001";s:14:"address_street";s:44:"625 Liberty Ave EQT plaza - AON - 10th floor";s:12:"payment_date";s:25:"04:44:31 Dec 19, 2016 PST";s:14:"payment_status";s:8:"Reversed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:10:"15222-3110";s:11:"mc_shipping";s:4:"0.00";s:11:"mc_handling";s:4:"0.00";s:10:"first_name";s:5:"terri";s:6:"mc_fee";s:5:"-0.27";s:16:"auction_buyer_id";s:8:"zipper95";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:16:"Terri L Hamilton";s:14:"notify_version";s:3:"3.8";s:11:"reason_code";s:18:"unauthorized_claim";s:6:"custom";s:26:"EBAY_EMSCX0000695518286311";s:8:"business";s:21:"itctflorida@gmail.com";s:15:"address_country";s:13:"United States";s:12:"mc_handling1";s:4:"0.00";s:12:"address_city";s:10:"Pittsburgh";s:11:"verify_sign";s:56:"AlObED.2c.sLLAH84Jr8bZje3vwSAN.avMwYdZWjVvncmS-y3Ie1.E-9";s:12:"mc_shipping1";s:4:"0.00";s:11:"payer_email";s:23:"bluegoose95@hotmail.com";s:4:"tax1";s:4:"0.00";s:13:"parent_txn_id";s:17:"88U5649028323845J";s:6:"txn_id";s:17:"1PK24584YL634650N";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:8:"hamilton";s:13:"address_state";s:2:"PA";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:11:"payment_fee";s:5:"-0.27";s:17:"shipping_discount";s:4:"0.00";s:9:"quantity1";s:1:"1";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:16:"insurance_amount";s:4:"0.00";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:8:"discount";s:4:"0.00";s:10:"mc_gross_1";s:4:"4.49";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:12:"111385463106";s:17:"residence_country";s:2:"US";s:15:"shipping_method";s:7:"Default";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:5:"-4.22";s:12:"ipn_track_id";s:13:"e4a0202df09ad";}';
//        $serialized = 'a:50:{s:8:"mc_gross";s:5:"-4.49";s:22:"protection_eligibility";s:8:"Eligible";s:12:"item_number1";s:12:"111385463106";s:8:"payer_id";s:13:"KHRMKHH7FTGHQ";s:12:"ebay_txn_id1";s:13:"1603597317001";s:14:"address_street";s:44:"625 Liberty Ave EQT plaza - AON - 10th floor";s:12:"payment_date";s:25:"08:07:11 Dec 30, 2016 PST";s:14:"payment_status";s:8:"Reversed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:10:"15222-3110";s:11:"mc_shipping";s:4:"0.00";s:11:"mc_handling";s:4:"0.00";s:10:"first_name";s:5:"terri";s:6:"mc_fee";s:5:"-0.27";s:16:"auction_buyer_id";s:8:"zipper95";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:16:"Terri L Hamilton";s:14:"notify_version";s:3:"3.8";s:11:"reason_code";s:18:"unauthorized_spoof";s:6:"custom";s:26:"EBAY_EMSCX0000695518286311";s:8:"business";s:21:"itctflorida@gmail.com";s:15:"address_country";s:13:"United States";s:12:"mc_handling1";s:4:"0.00";s:12:"address_city";s:10:"Pittsburgh";s:11:"verify_sign";s:56:"A9EwbxNCfqNC8PWq31G.JbRcLm4WAZ5ejWh3A70wdcSG3nXxWlJ3mnbK";s:12:"mc_shipping1";s:4:"0.00";s:11:"payer_email";s:23:"bluegoose95@hotmail.com";s:4:"tax1";s:4:"0.00";s:13:"parent_txn_id";s:17:"88U5649028323845J";s:6:"txn_id";s:17:"8MX6599309432990Y";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:8:"hamilton";s:13:"address_state";s:2:"PA";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:11:"payment_fee";s:5:"-0.27";s:17:"shipping_discount";s:4:"0.00";s:9:"quantity1";s:1:"1";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:16:"insurance_amount";s:4:"0.00";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:8:"discount";s:4:"0.00";s:10:"mc_gross_1";s:4:"4.49";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:12:"111385463106";s:17:"residence_country";s:2:"US";s:15:"shipping_method";s:7:"Default";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:5:"-4.49";s:12:"ipn_track_id";s:13:"dcbb0461bdedb";}';
//        $serialized = 'a:50:{s:8:"mc_gross";s:4:"4.22";s:22:"protection_eligibility";s:8:"Eligible";s:12:"item_number1";s:12:"111385463106";s:8:"payer_id";s:13:"KHRMKHH7FTGHQ";s:12:"ebay_txn_id1";s:13:"1603597317001";s:14:"address_street";s:44:"625 Liberty Ave EQT plaza - AON - 10th floor";s:12:"payment_date";s:25:"04:44:31 Dec 19, 2016 PST";s:14:"payment_status";s:17:"Canceled_Reversal";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:10:"15222-3110";s:11:"mc_shipping";s:4:"0.00";s:11:"mc_handling";s:4:"0.00";s:10:"first_name";s:5:"terri";s:6:"mc_fee";s:4:"0.27";s:16:"auction_buyer_id";s:8:"zipper95";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:16:"Terri L Hamilton";s:14:"notify_version";s:3:"3.8";s:11:"reason_code";s:18:"unauthorized_claim";s:6:"custom";s:26:"EBAY_EMSCX0000695518286311";s:8:"business";s:21:"itctflorida@gmail.com";s:15:"address_country";s:13:"United States";s:12:"mc_handling1";s:4:"0.00";s:12:"address_city";s:10:"Pittsburgh";s:11:"verify_sign";s:56:"AAJ8sHGjPsxLjCwiCHRzFxwimkULA8X3pO6-iOPulEn54ULoX6rMTQ5W";s:12:"mc_shipping1";s:4:"0.00";s:11:"payer_email";s:23:"bluegoose95@hotmail.com";s:4:"tax1";s:4:"0.00";s:13:"parent_txn_id";s:17:"88U5649028323845J";s:6:"txn_id";s:17:"1PK24584YL634650N";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:8:"hamilton";s:13:"address_state";s:2:"PA";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:11:"payment_fee";s:4:"0.27";s:17:"shipping_discount";s:4:"0.00";s:9:"quantity1";s:1:"1";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:16:"insurance_amount";s:4:"0.00";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:8:"discount";s:4:"0.00";s:10:"mc_gross_1";s:4:"4.49";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:12:"111385463106";s:17:"residence_country";s:2:"US";s:15:"shipping_method";s:7:"Default";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:4:"4.22";s:12:"ipn_track_id";s:13:"dcbb0461bdedb";}';
//        $serialized = 'a:29:{s:19:"transaction_subject";s:0:"";s:12:"payment_date";s:25:"07:41:54 Dec 30, 2016 PST";s:8:"txn_type";s:10:"web_accept";s:9:"last_name";s:8:"colletti";s:17:"residence_country";s:2:"US";s:9:"item_name";s:12:"Voice Credit";s:13:"payment_gross";s:5:"10.00";s:11:"mc_currency";s:3:"USD";s:8:"business";s:21:"itctflorida@gmail.com";s:12:"payment_type";s:7:"instant";s:22:"protection_eligibility";s:10:"Ineligible";s:11:"verify_sign";s:56:"AZEgj0Cs3KnvppEIazRuPtz9xZYTA-tTSx5gqLkbMJ.IbqW2O0wBNtzR";s:12:"payer_status";s:8:"verified";s:11:"payer_email";s:17:"pc.jhcc@yahoo.com";s:6:"txn_id";s:17:"1L531927US8089325";s:8:"quantity";s:1:"1";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:10:"first_name";s:5:"peter";s:8:"payer_id";s:13:"LSL79VCVSQH3C";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:11:"item_number";s:0:"";s:14:"payment_status";s:9:"Completed";s:11:"payment_fee";s:4:"0.55";s:6:"mc_fee";s:4:"0.55";s:8:"mc_gross";s:5:"10.00";s:6:"custom";s:0:"";s:7:"charset";s:5:"UTF-8";s:14:"notify_version";s:3:"3.8";s:12:"ipn_track_id";s:13:"5dc5b75abf23f";}';

        //Web IPN
//        $serialized='a:29:{s:19:"transaction_subject";s:0:"";s:12:"payment_date";s:25:"07:41:54 Dec 30, 2016 PST";s:8:"txn_type";s:10:"web_accept";s:9:"last_name";s:8:"colletti";s:17:"residence_country";s:2:"US";s:9:"item_name";s:12:"Voice Credit";s:13:"payment_gross";s:5:"10.00";s:11:"mc_currency";s:3:"USD";s:8:"business";s:21:"itctflorida@gmail.com";s:12:"payment_type";s:7:"instant";s:22:"protection_eligibility";s:10:"Ineligible";s:11:"verify_sign";s:56:"AZEgj0Cs3KnvppEIazRuPtz9xZYTA-tTSx5gqLkbMJ.IbqW2O0wBNtzR";s:12:"payer_status";s:8:"verified";s:11:"payer_email";s:17:"pc.jhcc@yahoo.com";s:6:"txn_id";s:17:"1L531927US8089325";s:8:"quantity";s:1:"1";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:10:"first_name";s:5:"peter";s:8:"payer_id";s:13:"LSL79VCVSQH3C";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:11:"item_number";s:0:"";s:14:"payment_status";s:9:"Completed";s:11:"payment_fee";s:4:"0.55";s:6:"mc_fee";s:4:"0.55";s:8:"mc_gross";s:5:"10.00";s:6:"custom";s:10:"4406022478";s:7:"charset";s:5:"UTF-8";s:14:"notify_version";s:3:"3.8";s:12:"ipn_track_id";s:13:"5dc5b75abf23f";}';
//        $ipn = unserialize($serialized);

//        $salesMessage        = new IpnSalesMessage($request->all());
        $ipnSalesMessage = $this->payPalService->validateIpn(new IpnSalesMessage($request->request->all()));

        $entity = new PayPalIpn($ipnSalesMessage);
        $this->em->persist($entity);
        $this->em->flush();
    }
}
