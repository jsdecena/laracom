<?php

namespace Tests\Feature\Admin\Provinces;

use App\Shop\Countries\Country;
use App\Shop\Provinces\Province;
use Tests\TestCase;

class ProvinceFeatureTest extends TestCase
{
    /** @test */
    public function it_can_update_the_province()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create([
            'country_id' => $country->id
        ]);

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.countries.provinces.update', [$country->id, $province->id]), ['name' => 'test'])
            ->assertStatus(302)
            ->assertRedirect(route('admin.countries.provinces.edit', [$country->id, $province->id]))
            ->assertSessionHas('message', 'Update successful');
    }
    
    /** @test */
    public function it_can_show_the_edit_form()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create([
            'country_id' => $country->id
        ]);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.countries.provinces.edit', [$country->id, $province->id]))
            ->assertStatus(200)
            ->assertSee($province->name);
    }

    /** @test */
    public function it_can_show_the_province()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create([
            'country_id' => $country->id
        ]);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.countries.provinces.show', [$country->id, $province->id]))
            ->assertStatus(200)
            ->assertSee($province->name);
    }
}
