<?php

namespace Tests\Unit\Countries;

use App\Countries\Exceptions\CountryInvalidArgumentException;
use App\Countries\Exceptions\CountryNotFoundException;
use App\Countries\Repositories\CountryRepository;
use App\Provinces\Province;
use App\Provinces\Repositories\ProvinceRepository;
use App\Countries\Country;
use Tests\TestCase;

class CountryUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_updating_the_country()
    {
        $country = factory(Country::class)->create();
        $this->expectException(CountryInvalidArgumentException::class);

        $countryRepo = new CountryRepository($country);
        $countryRepo->updateCountry(['name' => null]);
    }
    
    /** @test */
    public function it_can_update_the_country()
    {
        $country = factory(Country::class)->create();

        $countryRepo = new CountryRepository($country);

        $update = ['name' => 'Zimbabwe'];
        $countryRepo->updateCountry($update);

        $this->assertEquals('Zimbabwe', $country->name);
    }
    
    /** @test */
    public function it_can_find_the_provinces_associated_with_the_country()
    {
        $country = factory(Country::class)->create();
        $prov = factory(Province::class)->create(['country_id' => $country->id]);
        $country->provinces()->save($prov);

        $countryRepo = new CountryRepository($country);
        $provinces = $countryRepo->findProvinces();

        foreach ($provinces as $province) {
            $this->assertEquals($prov->id, $province->id);
        }

    }
    
    /** @test */
    public function it_errors_when_the_country_is_not_found()
    {
        $this->expectException(CountryNotFoundException::class);

        $countryRepo = new CountryRepository(new Country);
        $countryRepo->findCountryById(999);
    }
    
    /** @test */
    public function it_can_find_the_country()
    {
        $country = factory(Country::class)->create();
        $countryRepo = new CountryRepository($country);

        $found = $countryRepo->findCountryById($country->id);

        $this->assertEquals($country->name, $found->name);
    }

    /** @test */
    public function it_can_list_all_countries()
    {
        $countries = factory(Country::class, 3)->create();

        $this->assertCount(3, $countries);
    }
}