<?php

use App\Categories\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Category::class)->create([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'parent_id' => 0
        ]);
    }
}