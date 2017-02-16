<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use LaraCall\Domain\PriceList\ApiPriceListService;
use LaraCall\Events\PaymentCompleteEvent;

class testCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ApiPriceListService $priceListService
     */
    public function handle(
        ApiPriceListService $priceListService
    ) {
//        event(new PaymentCompleteEvent(3));
//        dd();

        $serialized = 'a:55:{s:8:"discount";s:4:"0.00";s:10:"mc_gross_1";s:4:"2.40";s:16:"insurance_amount";s:4:"0.00";s:12:"mc_handling1";s:4:"0.00";s:14:"num_cart_items";s:1:"1";s:8:"payer_id";s:13:"NXSM5LY6CLB6A";s:20:"address_country_code";s:2:"HU";s:12:"ipn_track_id";s:12:"b654d35cba45";s:11:"address_zip";s:4:"2162";s:7:"charset";s:5:"UTF-8";s:13:"payment_gross";s:0:"";s:14:"address_status";s:11:"unconfirmed";s:17:"shipping_discount";s:4:"0.00";s:11:"for_auction";s:4:"true";s:14:"address_street";s:12:"Peterdy G 12";s:11:"verify_sign";s:56:"AiPC9BjkCyDFQXbSkoZcgqH3hpacA2AKQ5nSlx8VFkDEVi.v.9EQc0yT";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:20:"auction_closing_date";s:25:"23:53:23 Apr 26, 2014 PDT";s:14:"pending_reason";s:14:"multi_currency";s:4:"tax1";s:4:"0.00";s:11:"mc_shipping";s:4:"0.00";s:8:"txn_type";s:4:"cart";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:12:"item_number1";s:12:"121328650482";s:11:"mc_currency";s:3:"GBP";s:19:"transaction_subject";s:0:"";s:15:"shipping_method";s:7:"Default";s:6:"custom";s:11:"15690217550";s:22:"protection_eligibility";s:8:"Eligible";s:9:"quantity1";s:1:"1";s:15:"address_country";s:7:"Hungary";s:12:"payer_status";s:10:"unverified";s:10:"first_name";s:8:"jozsefne";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:12:"address_name";s:14:"József Furesz";s:8:"mc_gross";s:4:"2.40";s:12:"mc_shipping1";s:4:"0.00";s:12:"payment_date";s:25:"23:55:58 Apr 26, 2014 PDT";s:14:"payment_status";s:7:"Pending";s:8:"business";s:21:"itctflorida@gmail.com";s:11:"item_number";s:12:"121328650482";s:11:"mc_handling";s:4:"0.00";s:9:"last_name";s:6:"Furesz";s:13:"address_state";s:4:"PEST";s:6:"txn_id";s:17:"6PH64061A1722450H";s:12:"ebay_txn_id1";s:13:"1277058340002";s:6:"resend";s:4:"true";s:12:"payment_type";s:7:"instant";s:14:"notify_version";s:3:"3.8";s:16:"auction_buyer_id";s:11:"fures_fures";s:11:"payer_email";s:18:"drfuresz@gmail.com";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:12:"address_city";s:11:"?rbottyán";s:3:"tax";s:4:"0.00";s:17:"residence_country";s:2:"HU";}';
        $serialized = 'a:47:{s:8:"mc_gross";s:4:"4.49";s:22:"protection_eligibility";s:8:"Eligible";s:11:"for_auction";s:4:"true";s:14:"address_status";s:9:"confirmed";s:12:"item_number1";s:12:"111385463106";s:3:"tax";s:4:"0.00";s:8:"payer_id";s:13:"KHRMKHH7FTGHQ";s:12:"ebay_txn_id1";s:13:"1603597317001";s:14:"address_street";s:44:"625 Liberty Ave EQT plaza - AON - 10th floor";s:12:"payment_date";s:25:"20:48:36 Dec 17, 2016 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:10:"15222-3110";s:11:"mc_shipping";s:4:"0.00";s:10:"first_name";s:5:"terri";s:6:"mc_fee";s:4:"0.27";s:16:"auction_buyer_id";s:8:"zipper95";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:16:"Terri L Hamilton";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:26:"EBAY_EMSCX0000695518286311";s:12:"payer_status";s:8:"verified";s:8:"business";s:21:"itctflorida@gmail.com";s:15:"address_country";s:13:"United States";s:14:"num_cart_items";s:1:"1";s:12:"address_city";s:10:"Pittsburgh";s:11:"verify_sign";s:56:"A5jg5FHbO3aWQKHd4A60fQrDAEioApeBJh3UrUCMnXSpJVnL.-WS32dK";s:11:"payer_email";s:23:"bluegoose95@hotmail.com";s:6:"txn_id";s:17:"88U5649028323845J";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:8:"hamilton";s:13:"address_state";s:2:"PA";s:10:"item_name1";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:14:"receiver_email";s:21:"itctflorida@gmail.com";s:11:"payment_fee";s:4:"0.27";s:9:"quantity1";s:1:"1";s:11:"receiver_id";s:13:"TNPCXAZWPE9YN";s:16:"insurance_amount";s:4:"0.00";s:8:"txn_type";s:4:"cart";s:9:"item_name";s:80:"Cheap International Calling Card $5 USD value. Instant PIN delivery! Phone card!";s:10:"mc_gross_1";s:4:"4.49";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:12:"111385463106";s:17:"residence_country";s:2:"US";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:4:"4.49";s:12:"ipn_track_id";s:13:"8663b3f2c689d";}';

        $unserialized = unserialize($serialized);

        foreach ($unserialized as $key=> $value) {
            echo sprintf('%s:%s' . "\n", $key, $value);
        }
//        $rates = $client->getPriceList()->getRates(13, 'hun');
//        $rates = $priceListService->getRates(13, 'usa');

//        $countries = $client->getPriceList()->getCountries();

//        $countries = $priceListService->getCountries();


//        $this->info(json_encode($rates, JSON_PRETTY_PRINT));
    }
}
