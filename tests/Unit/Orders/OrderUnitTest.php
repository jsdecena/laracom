<?php

namespace Tests\Unit\Orders;

use App\OrderDetails\Exceptions\OrderDetailInvalidArgumentException;
use App\Orders\Exceptions\OrderInvalidArgumentException;
use App\Orders\Exceptions\OrderNotFoundException;
use App\Orders\Order;
use App\Orders\Repositories\OrderRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrderUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_updating_the_product_with_needed_fields_not_passed()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $order = factory(Order::class)->create();
        $orderRepo = new OrderRepository($order);
        $orderRepo->updateOrder(['total_products' => null]);
    }

    /** @test */
    public function it_can_list_all_the_orders()
    {
        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $this->courier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'discounts' => 10.50,
            'total_products' =>  100,
            'total' => 100.00,
            'tax' => 10.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->createOrder($data);

        $lists = $orderRepo->listOrders();

        foreach ($lists as $found) {
            $this->assertEquals($data['reference'], $found->reference);
            $this->assertEquals($this->courier->id, $found->courier->id);
            $this->assertEquals($this->customer->id, $found->customer->id);
            $this->assertEquals($this->address->id, $found->address->id);
            $this->assertEquals($this->orderStatus->id, $found->orderStatus->id);
            $this->assertEquals($this->paymentMethod->id, $found->paymentMethod->id);
            $this->assertEquals($data['discounts'], $found->discounts);
            $this->assertEquals($data['total_products'], $found->total_products);
            $this->assertEquals($data['total_paid'], $found->total_paid);
            $this->assertEquals($data['invoice'], $found->invoice);
        }
    }
    
    /** @test */
    public function it_errors_looking_for_the_order_that_is_not_found()
    {
        $this->expectException(OrderNotFoundException::class);
        $this->expectExceptionMessage('Order not found.');

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->findOrderById(999);
    }
    
    /** @test */
    public function it_can_get_the_order()
    {
        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $this->courier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'discounts' => 10.50,
            'total_products' =>  100,
            'total' => 100.00,
            'tax' => 10.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $created = $orderRepo->createOrder($data);

        $found = $orderRepo->findOrderById($created->id);

        $this->assertEquals($data['reference'], $found->reference);
        $this->assertEquals($this->courier->id, $found->courier->id);
        $this->assertEquals($this->customer->id, $found->customer->id);
        $this->assertEquals($this->address->id, $found->address->id);
        $this->assertEquals($this->orderStatus->id, $found->orderStatus->id);
        $this->assertEquals($this->paymentMethod->id, $found->paymentMethod->id);
        $this->assertEquals($data['discounts'], $found->discounts);
        $this->assertEquals($data['total_products'], $found->total_products);
        $this->assertEquals($data['total_paid'], $found->total_paid);
        $this->assertEquals($data['invoice'], $found->invoice);
    }
    
    /** @test */
    public function it_can_update_the_order()
    {
        $order = factory(Order::class)->create();

        $orderRepo = new OrderRepository($order);

        $update = [
            'reference' => $this->faker->uuid,
            'courier_id' => $this->courier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'discounts' => 5.50,
            'total_products' =>  90.00,
            'total' => 100.00,
            'tax' => 10.00,
            'total_paid' => 100.00,
            'invoice' => null,
        ];

        $updated = $orderRepo->updateOrder($update);

        $this->assertEquals($update['reference'], $updated->reference);
        $this->assertEquals($update['courier_id'], $this->courier->id);
        $this->assertEquals($update['customer_id'], $this->customer->id);
        $this->assertEquals($update['address_id'], $this->address->id);
        $this->assertEquals($update['order_status_id'], $this->orderStatus->id);
        $this->assertEquals($update['payment_method_id'], $this->paymentMethod->id);
        $this->assertEquals($update['discounts'], $updated->discounts);
        $this->assertEquals($update['total_products'], $updated->total_products);
        $this->assertEquals($update['total_paid'], $updated->total_paid);
        $this->assertEquals($update['invoice'], $updated->invoice);
    }

    /** @test */
    public function it_errors_when_the_required_fields_are_not_passed()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $this->courier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->createOrder($data);
    }

    /** @test */
    public function it_errors_when_foreign_keys_are_not_found()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $data = [
            'reference' => $this->faker->uuid,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'discounts' => 10.50,
            'total_products' =>  100,
            'total' => 100.00,
            'tax' => 10.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->createOrder($data);
    }

    /** @test */
    public function it_can_create_an_order()
    {
        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $this->courier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'discounts' => 10.50,
            'total_products' =>  100,
            'total' => 100.00,
            'tax' => 10.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $created = $orderRepo->createOrder($data);

        $this->assertEquals($data['reference'], $created->reference);
        $this->assertEquals($data['courier_id'], $this->courier->id);
        $this->assertEquals($data['customer_id'], $this->customer->id);
        $this->assertEquals($data['address_id'], $this->address->id);
        $this->assertEquals($data['order_status_id'], $this->orderStatus->id);
        $this->assertEquals($data['payment_method_id'], $this->paymentMethod->id);
        $this->assertEquals($data['discounts'], $created->discounts);
        $this->assertEquals($data['total_products'], $created->total_products);
        $this->assertEquals($data['total_paid'], $created->total_paid);
        $this->assertEquals($data['invoice'], $created->invoice);
    }
}