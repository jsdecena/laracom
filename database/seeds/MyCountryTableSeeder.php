<?php

use App\Shop\Countries\Country;
use Illuminate\Database\Seeder;

class MyCountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('countries')->insert(array (
            0 =>
                array (
                    'id' => '1',
                    'iso' => 'BR',
                    'name' => 'BRAZIL',
                    'iso3' => 'BRA',
                    'numcode' => '76',
                    'phonecode' => '55',
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ),
        ));
    }
}
