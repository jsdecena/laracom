<?php

namespace Tests\Unit\OrderStatuses;

use App\Shop\OrderStatuses\Exceptions\OrderStatusInvalidArgumentException;
use App\Shop\OrderStatuses\Exceptions\OrderStatusNotFoundException;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use Tests\TestCase;

class OrderStatusUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_updating_the_order_status()
    {
        $this->expectException(OrderStatusInvalidArgumentException::class);

        $orderStatusRepo = new OrderStatusRepository($this->orderStatus);
        $orderStatusRepo->updateOrderStatus(['name' => null]);
    }

    /** @test */
    public function it_can_delete_the_order_status()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->createOrderStatus($create);

        $orderStatusRepo->deleteOrderStatus($os);

        $this->assertDatabaseMissing('order_statuses', $os->toArray());
    }
    
    /** @test */
    public function it_lists_all_the_order_statuses()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatusRepo->createOrderStatus($create);

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $lists = $orderStatusRepo->listOrderStatuses();

        foreach ($lists as $list) {
            $this->assertDatabaseHas('order_statuses', ['name' => $list->name]);
            $this->assertDatabaseHas('order_statuses', ['color' => $list->color]);
        }
    }
    
    /** @test */
    public function it_errors_getting_not_existing_order_status()
    {
        $this->expectException(OrderStatusNotFoundException::class);
        $this->expectExceptionMessage('Order status not found.');

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatusRepo->findOrderStatusById(999);
    }
    
    /** @test */
    public function it_can_get_the_order_status()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatus = $orderStatusRepo->createOrderStatus($create);

        $os = $orderStatusRepo->findOrderStatusById($orderStatus->id);

        $this->assertEquals($create['name'], $os->name);
        $this->assertEquals($create['color'], $os->color);
    }
    
    /** @test */
    public function it_can_update_the_order_status()
    {
        $orderStatusRepo = new OrderStatusRepository($this->orderStatus);

        $update = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $updatedOrderStatus = $orderStatusRepo->updateOrderStatus($update);

        $this->assertEquals($update['name'], $updatedOrderStatus->name);
        $this->assertEquals($update['color'], $updatedOrderStatus->color);
    }
    
    /** @test */
    public function it_errors_when_creating_the_order_status()
    {
        $this->expectException(OrderStatusInvalidArgumentException::class);

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatusRepo->createOrderStatus([]);
    }
    
    /** @test */
    public function it_can_create_the_order_status()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatus = $orderStatusRepo->createOrderStatus($create);

        $this->assertEquals($create['name'], $orderStatus->name);
        $this->assertEquals($create['color'], $orderStatus->color);
    }
}