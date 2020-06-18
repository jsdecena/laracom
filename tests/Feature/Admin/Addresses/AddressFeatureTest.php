<?php

namespace Tests\Feature\Admin\Addresses;

use App\Shop\Addresses\Address;
use App\Shop\Customers\Customer;
use App\Shop\Provinces\Province;
use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use Tests\TestCase;

class AddressFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_edit_page()
    {
        factory(City::class)->create();
        $address = factory(Address::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.addresses.edit', $address->id))
            ->assertStatus(200)
            ->assertSee($address->alias)
            ->assertSee($address->address_1);
    }
    
    /** @test */
    public function it_can_show_the_create_address_page()
    {
        factory(Country::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.addresses.create'))
            ->assertStatus(200)
            ->assertSee($this->customer->name);
    }
    
    /** @test */
    public function it_can_delete_the_address()
    {
        factory(City::class)->create();
        $address = factory(Address::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.addresses.destroy', $address->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.addresses.index'))
            ->assertSessionHas('message', 'Delete successful');
    }

    /** @test */
    public function it_can_show_the_address()
    {
        factory(City::class)->create();
        $address = factory(Address::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.addresses.show', $address->id))
            ->assertStatus(200)
            ->assertSee($address->alias);
        ;
    }
    
    /** @test */
    public function it_can_search_for_the_address()
    {
        factory(City::class)->create();
        $address = factory(Address::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.addresses.index', ['q' => $address->alias]))
            ->assertStatus(200)
            ->assertSee($address->alias);
    }

    /** @test */
    public function it_can_list_all_the_addresses()
    {
        factory(City::class)->create();
        $address = factory(Address::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.addresses.index'))
            ->assertStatus(200)
            ->assertSee(htmlentities($address->alias, ENT_QUOTES))
            ->assertSee(htmlentities($address->address_1, ENT_QUOTES));
    }

    /** @test */
    public function it_can_update_the_address()
    {
        $address = factory(Address::class)->create();

        $data = [
            'alias' => $this->faker->word,
            'address_1' => $this->faker->streetName,
            'status' => 1
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.addresses.update', $address->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.addresses.edit', $address->id))
            ->assertSessionHas('message');
    }

    /** @test */
    public function it_errors_updating_the_address()
    {
        $this->actingAs($this->employee, 'employee')
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

        $this->actingAs($this->employee, 'employee')
            ->post(route('admin.addresses.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.addresses.index'))
            ->assertSessionHas('message');
    }
}
