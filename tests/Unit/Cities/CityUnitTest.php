<?php

namespace Tests\Unit\Cities;

use App\Shop\Cities\Exceptions\CityNotFoundException;
use App\Shop\Cities\Repositories\CityRepository;
use App\Shop\Cities\City;
use Tests\TestCase;

class CityUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_cities()
    {
        $city = factory(City::class)->create();
        $cityRepo = new CityRepository($city);

        $this->assertCount(1, $cityRepo->listCities());
    }
    
    /** @test */
    public function it_can_update_the_city()
    {
        $city = factory(City::class)->create();
        $cityRepo = new CityRepository($city);

        $update = ['name' => 'Manila'];
        $updated = $cityRepo->updateCity($update);

        $this->assertTrue($updated);
    }
    
    /** @test */
    public function it_will_error_when_city_is_not_found()
    {
        $this->expectException(CityNotFoundException::class);

        $cityRepo = new CityRepository(new City);
        $cityRepo->findCityByName('unknown');
    }

    /** @test */
    public function it_can_find_the_city()
    {
        $city = factory(City::class)->create();
        $cityRepo = new CityRepository(new City);
        $found = $cityRepo->findCityByName($city->name);

        $this->assertEquals($city->name, $found->name);
    }
}
