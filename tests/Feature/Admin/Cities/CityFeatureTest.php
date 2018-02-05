<?php

namespace Tests\Feature;

use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use App\Shop\Provinces\Province;
use Tests\TestCase;

class CityFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_edit_page()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create([
            'country_id' => $country->id
        ]);
        $city = factory(City::class)->create([
            'province_id' => $province->id
        ]);

        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.countries.provinces.cities.edit', [$country->id, $province->id, $city->id]))
            ->assertStatus(200)
            ->assertSee($city->name);
    }
    
    /** @test */
    public function it_error_when_the_city_name_is_already_existing()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create();
        $city = factory(City::class)->create();
        $city2 = factory(City::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->put(route('admin.countries.provinces.cities.update', [$country->id, $province->id, $city->id]), ['name' => $city2->name])
            ->assertSessionHasErrors();
    }
    
    /** @test */
    public function it_can_update_the_city()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create();
        $city = factory(City::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->put(route('admin.countries.provinces.cities.update', [$country->id, $province->id, $city->id]), ['name' => 'manila'])
            ->assertStatus(302)
            ->assertSessionHas('message', 'Update successful');
    }
}
