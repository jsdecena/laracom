<?php

use Illuminate\Database\Seeder;

class MyCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cities')->insert(array (
            0 =>
                array (
                    'name' => 'Rio de Janeiro',
                    'province_id' => '1',
                ),
            1 =>
                array (
                    'name' => 'Teresópolis',
                    'province_id' => '1',
                ),
            2 =>
                array (
                    'name' => 'Guapimirin',
                    'province_id' => '1',
                ),
            3 =>
                array (
                    'name' => 'Duque de Caxias',
                    'province_id' => '1',
                ),
            4 =>
                array (
                    'name' => 'Niteroi',
                    'province_id' => '1',
                ),
        ));
    }
}
