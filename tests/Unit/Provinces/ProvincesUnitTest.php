<?php

namespace Tests\Unit\Provinces;

use App\Shop\Provinces\Exceptions\ProvinceNotFoundException;
use App\Shop\Provinces\Province;
use App\Shop\Provinces\Repositories\ProvinceRepository;
use App\Shop\Cities\City;
use Tests\TestCase;

class ProvincesUnitTest extends TestCase
{
    /** @test */
    public function it_will_error_when_the_province_is_not_found()
    {
        $this->expectException(ProvinceNotFoundException::class);
        $this->expectExceptionMessage('Province not found.');

        $provinceRepo = new ProvinceRepository(new Province);
        $provinceRepo->findProvinceById(999);
    }
    
    /** @test */
    public function it_can_show_the_province()
    {
        $province = factory(Province::class)->create();
        $provinceRepo = new ProvinceRepository(new Province);
        $found = $provinceRepo->findProvinceById($province->id);

        $this->assertEquals($province->name, $found->name);
    }
    
    /** @test */
    public function it_can_list_all_the_cities_within_the_province()
    {
        $province = factory(Province::class)->create();

        $city = new City(['name' => $this->faker->city]);
        $city->province()->associate($province);
        $province->cities()->save($city);
        $cities = $province->cities()->get();

        $this->assertCount(1, $cities);
    }
    
    /** @test */
    public function it_can_list_all_the_provinces()
    {
        $provinceRepo = new ProvinceRepository(new Province);
        $provinces = $provinceRepo->listProvinces();

        foreach ($provinces as $province) {
            $this->assertDatabaseHas('provinces', $province->toArray());
        }
    }
}
