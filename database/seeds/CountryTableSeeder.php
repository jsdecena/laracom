<?php

use App\Countries\Country;
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
        factory(Country::class)->create(['id' => 169]);
    }
}
