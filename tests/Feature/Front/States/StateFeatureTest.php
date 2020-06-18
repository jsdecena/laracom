<?php

namespace Tests\Feature\Front\States;

use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use App\Shop\States\State;
use Tests\TestCase;

class StateFeatureTest extends TestCase
{
    /** @test */
    public function it_can_list_cities()
    {
        $country = factory(Country::class)->create([
            'name' => 'United States of America',
            'iso' => 'US'
        ]);

        $usState = factory(State::class)->create([
            'country_id' => $country->id
        ]);

        $city = factory(City::class)->create([
            'state_code' => $usState->state_code
        ]);

        $this->actingAs($this->customer)
            ->get(route('state.city.index', $usState->state_code))
            ->assertJsonFragment(['name' => $city->name])
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_list_all_the_states()
    {
        $country = factory(Country::class)->create([
            'name' => $this->faker->country,
            'iso' => 'US'
        ]);

        $usState = factory(State::class)->create([
            'country_id' => $country->id,
        ]);

        $this->actingAs($this->customer)
            ->get(route('country.state.index', $country->id))
            ->assertJsonFragment(['state' => $usState->state])
            ->assertStatus(200);
    }
}