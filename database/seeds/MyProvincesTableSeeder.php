<?php

use Illuminate\Database\Seeder;

class MyProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('provinces')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'country_id' => 1,
                    'name' => 'RJ',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
        ));
    }
}
