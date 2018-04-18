<?php

use Laracommerce\Core\Warehouse\Warehouse;
use Illuminate\Database\Seeder;

/**
 * Class WarehouseTableSeeder.
 */
class WarehouseTableSeeder extends Seeder
{
    public function run()
    {
        factory(Warehouse::class)->create([
            'name' => Warehouse::DEFAULT_NAME,
        ]);
    }
}