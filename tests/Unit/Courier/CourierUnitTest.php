<?php

namespace Tests\Unit\Courier;

use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Exceptions\CourierInvalidArgumentException;
use App\Shop\Couriers\Exceptions\CourierNotFoundException;
use App\Shop\Couriers\Repositories\CourierRepository;
use Tests\TestCase;

class CourierUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_couriers()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $courierRepo = new CourierRepository(new Courier);
        $courierRepo->createCourier($data);

        $lists = $courierRepo->listCouriers();

        foreach ($lists as $list) {
            $this->assertDatabaseHas('couriers', ['name' => $list->name]);
            $this->assertDatabaseHas('couriers', ['description' => $list->description]);
            $this->assertDatabaseHas('couriers', ['url' => $list->url]);
            $this->assertDatabaseHas('couriers', ['is_free' => $list->is_free]);
            $this->assertDatabaseHas('couriers', ['status' => $list->status]);
        }
    }
    
    /** @test */
    public function it_errors_when_the_courier_is_not_found()
    {
        $this->expectException(CourierNotFoundException::class);
        $this->expectExceptionMessage('Courier not found.');

        $courierRepo = new CourierRepository(new Courier);
        $courierRepo->findCourierById(999);
    }
    
    /** @test */
    public function it_can_get_the_courier()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $courierRepo = new CourierRepository(new Courier);
        $created = $courierRepo->createCourier($data);

        $found = $courierRepo->findCourierById($created->id);

        $this->assertEquals($data['name'], $found->name);
        $this->assertEquals($data['description'], $found->description);
        $this->assertEquals($data['url'], $found->url);
        $this->assertEquals($data['is_free'], $found->is_free);
        $this->assertEquals($data['status'], $found->status);
    }
    
    /** @test */
    public function it_errors_updating_the_courier()
    {
        $this->expectException(CourierInvalidArgumentException::class);

        $courierRepo = new CourierRepository($this->courier);
        $courierRepo->updateCourier(['name' => null]);
    }
    
    /** @test */
    public function it_can_update_the_courier()
    {
        $courierRepo = new CourierRepository($this->courier);

        $update = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $updated = $courierRepo->updateCourier($update);

        $this->assertTrue($updated);
        $this->assertEquals($update['name'], $this->courier->name);
        $this->assertEquals($update['description'], $this->courier->description);
        $this->assertEquals($update['url'], $this->courier->url);
        $this->assertEquals($update['is_free'], $this->courier->is_free);
        $this->assertEquals($update['status'], $this->courier->status);
    }
    
    /** @test */
    public function it_errors_when_creating_the_courier()
    {
        $this->expectException(CourierInvalidArgumentException::class);

        $courierRepo = new CourierRepository(new Courier);
        $courierRepo->createCourier([]);
    }
    
    /** @test */
    public function it_can_create_a_courier()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $courierRepo = new CourierRepository(new Courier);
        $created = $courierRepo->createCourier($data);

        $this->assertEquals($data['name'], $created->name);
        $this->assertEquals($data['description'], $created->description);
        $this->assertEquals($data['url'], $created->url);
        $this->assertEquals($data['is_free'], $created->is_free);
        $this->assertEquals($data['status'], $created->status);
    }
}
