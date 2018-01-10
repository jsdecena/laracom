<?php

namespace Tests\Feature\Addresses;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Customers\Customer;
use App\Shop\Provinces\Province;
use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use Tests\TestCase;

class AddressFeatureTest extends TestCase 
{
    /** @test */
    public function it_errors_updating_the_address()
    {
        $this->actingAs($this->employee, 'admin')
            ->post(route('admin.addresses.store', ['alias' => null]))
            ->assertSessionHasErrors(['alias' => 'The alias field is required.']);
    }
    
    /** @test */
    public function it_can_create_address()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create();
        $city = factory(City::class)->create();
        $customer = factory(Customer::class)->create();

        $data = [
            'alias' => $this->faker->word,
            'address_1' => $this->faker->streetName,
            'address_2' => $this->faker->streetAddress,
            'zip' => $this->faker->postcode,
            'city_id' => $city->id,
            'province_id' => $province->id,
            'country_id' => $country->id,
            'customer_id' => $customer->id,
            'status' => 1
        ];

        $this->actingAs($this->employee, 'admin')
            ->post(route('admin.addresses.store', $data))
            ->assertStatus(302)
            ->assertRedirect(route('admin.addresses.index'))
            ->assertSessionHas('message');
    }
}