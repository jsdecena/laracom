<?php

namespace Tests\Feature;

use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use App\Shop\Provinces\Province;
use App\Shop\States\State;
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

        $state = factory(State::class)->create();

        $city = factory(City::class)->create([
            'province_id' => $province->id,
            'state_code' => $state->state_code
        ]);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.countries.provinces.cities.edit', [$country->id, $province->id, $city->name]))
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
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.countries.provinces.cities.update', [$country->id, $province->id, $city->id]), ['name' => $city2->name])
            ->assertSessionHasErrors();
    }
}
