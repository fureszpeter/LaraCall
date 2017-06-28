<?php

use Illuminate\Database\Migrations\Migration;

class AddMinStockToPriceList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `ebay_price_lists` ADD `min_stock` INT NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `ebay_price_lists` DROP `min_stock`');
    }
}
