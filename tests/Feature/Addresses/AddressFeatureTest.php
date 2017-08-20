<?php

namespace Tests\Feature\Addresses;

use App\Addresses\Address;
use App\Addresses\Repositories\AddressRepository;
use App\Customers\Customer;
use App\Provinces\Province;
use App\Cities\City;
use App\Countries\Country;
use Tests\TestCase;

class AddressFeatureTest extends TestCase 
{
    /** @test */
    public function it_can_return_the_owner_of_the_address()
    {
        $customer = factory(Customer::class)->create();
        $address = factory(Address::class)->create(['customer_id' => $customer->id]);

        $addressRepo = new AddressRepository($address);

        $found = $addressRepo->findCustomer();

        $this->assertEquals($customer->name, $found->name);
    }

    /** @test */
    public function it_can_be_attached_to_a_customer()
    {
        $customer = factory(Customer::class)->create();
        $address = factory(Address::class)->create();

        $addressRepo = new AddressRepository($address);
        $addressRepo->attachToCustomer($address, $customer);

        $this->assertEquals($customer->name, $address->customer->name);
    }
    
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