<?php

use App\Shop\Attributes\Attribute;
use App\Shop\AttributeValues\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder
{
    public function run()
    {
        $sizeAttr = factory(Attribute::class)->create(['name' => 'Size']);
        factory(AttributeValue::class)->create([
            'value' => 'small',
            'attribute_id' => $sizeAttr->id
        ]);

        factory(AttributeValue::class)->create([
            'value' => 'medium',
            'attribute_id' => $sizeAttr->id
        ]);

        factory(AttributeValue::class)->create([
            'value' => 'large',
            'attribute_id' => $sizeAttr->id
        ]);

        $colorAttr = factory(Attribute::class)->create(['name' => 'Color']);

        factory(AttributeValue::class)->create([
            'value' => 'red',
            'attribute_id' => $colorAttr->id
        ]);

        factory(AttributeValue::class)->create([
            'value' => 'yellow',
            'attribute_id' => $colorAttr->id
        ]);

        factory(AttributeValue::class)->create([
            'value' => 'blue',
            'attribute_id' => $colorAttr->id
        ]);
    }
}