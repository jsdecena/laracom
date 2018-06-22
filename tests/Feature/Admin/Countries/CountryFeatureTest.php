<?php

namespace Tests\Feature\Admin\Countries;

use App\Shop\Countries\Country;
use Tests\TestCase;

class CountryFeatureTest extends TestCase
{
    /** @test */
    public function it_can_update_the_country()
    {
        $data = ['name' => $this->faker->name];
        $country = factory(Country::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.countries.update', $country->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.countries.edit', $country->id))
            ->assertSessionHas('message', 'Update successful');
    }
    
    /** @test */
    public function it_can_show_the_country()
    {
        $country = factory(Country::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.countries.show', $country->id))
            ->assertStatus(200)
            ->assertSee(htmlentities($country->name, ENT_QUOTES));
    }
    
    /** @test */
    public function it_can_list_all_the_countries()
    {
        $country = factory(Country::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.countries.index'))
            ->assertStatus(200)
            ->assertSee(htmlentities($country->name, ENT_QUOTES));
    }

    /** @test */
    public function it_can_show_the_edit_country()
    {
        $country = factory(Country::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.countries.edit', $country->id))
            ->assertStatus(200)
            ->assertSee(htmlentities($country->name, ENT_QUOTES));
    }
}
