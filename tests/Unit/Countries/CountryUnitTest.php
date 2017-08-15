<?php

namespace Tests\Unit\Countries;

use App\Countries\Exceptions\CountryInvalidArgumentException;
use App\Countries\Exceptions\CountryNotFoundException;
use App\Countries\Repositories\CountryRepository;
use Jsdecena\MCPro\Models\Country;
use Tests\TestCase;

class CountryUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_updating_the_country()
    {
        $this->expectException(CountryInvalidArgumentException::class);

        $countryRepo = new CountryRepository($this->country);
        $countryRepo->updateCountry(['name' => null]);
    }
    
    /** @test */
    public function it_can_update_the_country()
    {
        $countryRepo = new CountryRepository($this->country);
        $country = $countryRepo->updateCountry(['name' => 'Boboboi']);

        $this->assertEquals('Boboboi', $country->name);
    }
    
    /** @test */
    public function it_can_find_the_provinces_associated_with_the_country()
    {
        $countryRepo = new CountryRepository($this->country);
        $provinces = $countryRepo->findProvinces();

        foreach ($provinces as $province) {
            $this->assertEquals($this->province->id, $province->id);
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
        $countryRepo = new CountryRepository($this->country);
        $country = $countryRepo->findCountryById($this->country->id);

        $this->assertEquals($this->country->name, $country->name);
    }

    /** @test */
    public function it_can_list_all_countries()
    {
        $countryRepo = new CountryRepository($this->country);
        $list = $countryRepo->listCountries();

        $this->assertEquals($this->country->name, $list[1]->name);
    }
}