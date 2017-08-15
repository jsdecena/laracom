<?php

namespace Tests\Feature\Addresses;

use Tests\TestCase;

class AddressFeatureTest extends TestCase 
{
    /** @test */
    public function it_can_create_address()
    {
        $addressData = [
            'alias' => 'Home',
            'address_1' => $this->faker->sentence,
            'address_2' => $this->faker->sentence,
            'zip' => 1101,
            'city_id' => $this->city->id,
            'province_id' => $this->province->id,
            'country_id' => $this->country->id,
            'customer_id' => $this->customer->id,
            'status' => 1
        ];

        $this->actingAs($this->employee, 'admin')
            ->post(route('addresses.store', $addressData))
            ->assertStatus(302)
            ->assertRedirect(route('addresses.index'))
            ->assertSessionHas('message');
    }
}