<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);
//        $this->call(CountriesTableSeeder::class);
//        $this->call(StatesTableSeeder::class);
//        $this->call(PayPalIpnsTableSeeder::class);
        $this->call(EbayPriceListsTableSeeder::class);
//        $this->call(SubscriptionsTableSeeder::class);
//        $this->call(PinsTableSeeder::class);
    }
}
