<?php

use App\Shop\Customers\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        DB::unprepared("
INSERT INTO `states` VALUES ('Rio de Janeiro', 'Rj', 1);
        ");
    }
}