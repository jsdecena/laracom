<?php

namespace Tests\Unit\Provinces;

use App\Shop\Countries\Country;
use App\Shop\Provinces\Exceptions\ProvinceNotFoundException;
use App\Shop\Provinces\Province;
use App\Shop\Provinces\Repositories\ProvinceRepository;
use App\Shop\Cities\City;
use Tests\TestCase;

class ProvincesUnitTest extends TestCase
{
    /** @test */
    public function it_should_show_the_country_of_the_province()
    {
        $country = factory(Country::class)->create();
        $province = factory(Province::class)->create([
            'country_id' => $country->id
        ]);

        $repo = new ProvinceRepository($province);
        $found = $repo->findCountry();

        $this->assertInstanceOf(Country::class, $found);
        $this->assertEquals($country->name, $found->name);
    }

    /** @test */
    public function it_error_updating_the_province_without_the_country()
    {
        $this->expectException(ProvinceNotFoundException::class);

        $province = factory(Province::class)->create();

        $data = [
            'name' => $this->faker->name,
            'country_id' => null
        ];

        $repo = new ProvinceRepository($province);
        $repo->updateProvince($data);
    }

    /** @test */
    public function it_can_list_cities()
    {
        $province = factory(Province::class)->create();
        $city = factory(City::class)->create([
            'province_id' => $province->id
        ]);

        $repo = new ProvinceRepository(new Province());
        $collection = $repo->listCities($province->id);

        $collection->each(function ($item) use ($city) {
            $this->assertEquals($item->name, $city->name);
        });
    }

    /** @test */
    public function it_can_update_the_province()
    {
        $province = factory(Province::class)->create();

        $data = [
            'name' => $this->faker->name
        ];

        $repo = new ProvinceRepository($province);
        $repo->updateProvince($data);

        $this->assertEquals($data['name'], $province->name);
    }

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
        factory(Province::class, 5)->create();
        $provinceRepo = new ProvinceRepository(new Province);
        $provinces = $provinceRepo->listProvinces();

        foreach ($provinces as $province) {
            $this->assertDatabaseHas('provinces', $province->toArray());
        }
    }
}
