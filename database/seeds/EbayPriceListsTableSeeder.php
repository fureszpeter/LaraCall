<?php

use Illuminate\Database\Seeder;

class EbayPriceListsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ebay_price_lists')->delete();
        
        \DB::table('ebay_price_lists')->insert(array (
            0 => 
            array (
                'item_id' => '110190666836',
                'product_value' => '5',
                'product_price' => '4.49',
                'currency' => 'USD',
                'tariff_id' => 13,
                'description' => 'SANDBOX Ebay 5 USD card',
                'deleted' => 0,
                'created_at' => '2017-01-17 00:00:00',
                'updated_at' => '2017-01-17 00:00:00',
            ),
            1 => 
            array (
                'item_id' => '111385463106',
                'product_value' => '5',
                'product_price' => '4.49',
                'currency' => 'USD',
                'tariff_id' => 13,
                'description' => 'Ebay 5 USD card',
                'deleted' => 0,
                'created_at' => '2017-01-17 00:00:00',
                'updated_at' => '2017-01-17 00:00:00',
            ),
            2 => 
            array (
                'item_id' => '121371844968',
                'product_value' => '1',
                'product_price' => '1',
                'currency' => 'EUR',
                'tariff_id' => 13,
                'description' => 'Ebay 1 EUR card',
                'deleted' => 0,
                'created_at' => '2017-01-17 00:00:00',
                'updated_at' => '2017-01-17 00:00:00',
            ),
        ));
        
        
    }
}