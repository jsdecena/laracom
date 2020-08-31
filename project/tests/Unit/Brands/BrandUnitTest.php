<?php

namespace Tests\Unit\Brands;

use App\Shop\Brands\Brand;
use App\Shop\Brands\Repositories\BrandRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BrandUnitTest extends TestCase
{
    /** @test */
    public function it_can_show_all_the_brands()
    {
        factory(Brand::class, 3)->create();

        $brandRepo = new BrandRepository(new Brand);
        $list = $brandRepo->listBrands();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertCount(3, $list->all());
    }
    
    /** @test */
    public function it_can_delete_the_brand()
    {
        $brand = factory(Brand::class)->create();

        $brandRepo = new BrandRepository($brand);
        $deleted = $brandRepo->deleteBrand($brand->id);

        $this->assertTrue($deleted);
    }
    
    /** @test */
    public function it_can_update_the_brand()
    {
        $brand = factory(Brand::class)->create();

        $data = ['name' => 'Argentina'];

        $brandRepo = new BrandRepository($brand);
        $updated = $brandRepo->updateBrand($data);

        $found = $brandRepo->findBrandById($brand->id);

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $found->name);
    }
    
    /** @test */
    public function it_can_show_the_brand()
    {
        $brand = factory(Brand::class)->create();

        $brandRepo = new BrandRepository(new Brand);
        $found = $brandRepo->findBrandById($brand->id);

        $this->assertInstanceOf(Brand::class, $found);
        $this->assertEquals($brand->name, $found->name);
    }
    
    /** @test */
    public function it_can_create_a_brand()
    {
        $data = ['name' => $this->faker->company];

        $brandRepo = new BrandRepository(new Brand);
        $brand = $brandRepo->createBrand($data);

        $this->assertInstanceOf(Brand::class, $brand);
        $this->assertEquals($data['name'], $brand->name);
    }
}
