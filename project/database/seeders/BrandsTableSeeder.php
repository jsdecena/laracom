<?php
namespace Database\Seeders;
use App\Shop\Brands\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Brand::class)->create([
            'name' => 'Apple'
        ]);
    }
}