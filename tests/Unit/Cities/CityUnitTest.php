<?php

namespace Tests\Unit\Cities;

use App\Cities\Exceptions\CityNotFoundException;
use App\Cities\Repositories\CityRepository;
use Jsdecena\MCPro\Models\City;
use Tests\TestCase;

class CityUnitTest extends TestCase 
{
    /** @test */
    public function it_can_update_the_city()
    {
        $city = new CityRepository($this->city);
        $ct = $city->updateCity(['name' => 'Manila']);

        $this->assertEquals($ct->name, $this->city->name);

    }
    
    /** @test */
    public function it_will_error_when_city_is_not_found()
    {
        $this->expectException(CityNotFoundException::class);

        $cityRepo = new CityRepository(new City);
        $cityRepo->findCityById(999);
    }

    /** @test */
    public function it_can_find_the_city()
    {
        $cityRepo = new CityRepository(new City);
        $city = $cityRepo->findCityById($this->city->id);

        $this->assertEquals($this->city->name, $city->name);
    }
}