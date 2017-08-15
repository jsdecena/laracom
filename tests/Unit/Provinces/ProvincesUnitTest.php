<?php

namespace Tests\Unit\Provinces;

use App\Provinces\Exceptions\ProvinceNotFoundException;
use App\Provinces\Repositories\ProvinceRepository;
use Jsdecena\MCPro\Models\Province;
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
        $provinceRepo = new ProvinceRepository(new Province);
        $province = Province::find(1);
        $found = $provinceRepo->findProvinceById($province->id);

        $this->assertEquals($province->name, $found->name);
    }
    
    /** @test */
    public function it_can_list_all_the_cities_within_the_province()
    {
        $provinceRepo = new ProvinceRepository(new Province);
        $cities = $provinceRepo->listCities(Province::find(1));

        foreach ($cities as $city) {
            $this->assertDatabaseHas('cities', $city->toArray());
        }
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