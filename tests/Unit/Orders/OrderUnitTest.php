<?php

namespace Tests\Unit\Orders;

use App\Shop\Addresses\Address;
use App\Shop\Couriers\Courier;
use App\Shop\Customers\Customer;
use App\Events\OrderCreateEvent;
use App\Mail\sendEmailNotificationToAdminMailable;
use App\Mail\SendOrderToCustomerMailable;
use App\Shop\Orders\Exceptions\OrderInvalidArgumentException;
use App\Shop\Orders\Exceptions\OrderNotFoundException;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\Products\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderUnitTest extends TestCase
{
    /** @test */
    public function it_can_transform_the_order()
    {
        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal'
        ];

        $order = factory(Order::class)->create($data);
        $repo = new OrderRepository($order);
        $transformed = $repo->transform();

        $this->assertEquals($customer->name, $transformed->customer->name);
        $this->assertEquals($courier->name, $transformed->courier->name);
        $this->assertEquals($address->alias, $transformed->address->alias);
        $this->assertEquals($orderStatus->name, $transformed->status->name);
        $this->assertEquals($data['payment'], $order->payment);
    }

    /** @test */
    public function it_can_search_for_order()
    {
        $customer = factory(Customer::class)->create(['name' => 'Test Customer']);
        $order = factory(Order::class)->create([
            'customer_id' => $customer->id,
            'reference' => 'testing-12345'
        ]);

        factory(Order::class)->create();

        $repo = new OrderRepository($order);
        $result = $repo->searchOrder('test');

        $this->assertEquals(1, $result->count());

        $result->each(function ($item) use ($order) {
            $this->assertEquals($item->reference, $order->reference);
            $this->assertEquals($item->courier_id, $order->courier_id);
            $this->assertEquals($item->customer_id, $order->customer_id);
            $this->assertEquals($item->address_id, $order->address_id);
        });
    }

    /** @test */
    public function it_should_return_all_orders_when_searched_by_empty_string()
    {
        $customer = factory(Customer::class)->create(['name' => 'Test Customer']);
        $order = factory(Order::class)->create(['customer_id' => $customer->id]);
        factory(Order::class)->create(['customer_id' => 10]);

        $repo = new OrderRepository($order);
        $result = $repo->searchOrder('');

        $this->assertEquals(2, $result->count());
    }

    /** @test */
    public function it_can_send_email_to_customer()
    {
        Mail::fake();

        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $product = factory(Product::class)->create();
        Cart::add($product, 1);

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal',
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->createOrder($data);

        Mail::assertSent(SendOrderToCustomerMailable::class);
        Mail::assertSent(sendEmailNotificationToAdminMailable::class);
    }

    /** @test */
    public function it_should_deduct_the_quantity_of_the_product_when_an_order_is_created()
    {
        $product = factory(Product::class)->create(['quantity' => 9]);
        $order = factory(Order::class)->create();

        $orderRepo = new OrderRepository($order);
        $orderRepo->associateProduct($product, 5);

        $this->assertEquals(4, $product->quantity);
    }

    /** @test */
    public function it_can_associate_the_product_in_the_order()
    {
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create();

        $orderRepo = new OrderRepository($order);
        $orderRepo->associateProduct($product);

        $products = $orderRepo->findProducts($order);

        foreach ($products as $p) {
            $this->assertEquals($product->name, $p->name);
            $this->assertEquals($product->sku, $p->sku);
            $this->assertEquals($product->description, $p->description);
        }
    }

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
        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal',
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $this->expectsEvents(OrderCreateEvent::class);

        $orderRepo = new OrderRepository(new Order);
        $order = $orderRepo->createOrder($data);

        $orderRepo = new OrderRepository($order);
        $product = factory(Product::class)->create();
        $orderRepo->associateProduct($product);

        $lists = $orderRepo->listOrders();

        foreach ($lists as $found) {
            $this->assertEquals($data['reference'], $found->reference);
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

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->findOrderById(999);
    }

    /** @test */
    public function it_can_get_the_order()
    {
        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal',
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $created = $orderRepo->createOrder($data);

        $found = $orderRepo->findOrderById($created->id);

        $this->assertEquals($data['reference'], $found->reference);
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

        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal',
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $updated = $orderRepo->updateOrder($data);

        $this->assertTrue($updated);
        $this->assertEquals($data['reference'], $order->reference);
        $this->assertEquals($data['discounts'], $order->discounts);
        $this->assertEquals($data['total_products'], $order->total_products);
        $this->assertEquals($data['total_paid'], $order->total_paid);
        $this->assertEquals($data['invoice'], $order->invoice);
    }

    /** @test */
    public function it_errors_when_the_required_fields_are_not_passed()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal',
            'discounts' => 10.50,
            'total_products' =>  100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->createOrder($data);
    }

    /** @test */
    public function it_errors_when_foreign_keys_are_not_found()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal',
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->createOrder($data);
    }

    /** @test */
    public function it_can_create_an_order()
    {
        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment' => 'paypal',
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepo = new OrderRepository(new Order);
        $created = $orderRepo->createOrder($data);

        $this->assertEquals($data['reference'], $created->reference);
        $this->assertEquals($data['courier_id'], $courier->id);
        $this->assertEquals($data['customer_id'], $customer->id);
        $this->assertEquals($data['address_id'], $address->id);
        $this->assertEquals($data['discounts'], $created->discounts);
        $this->assertEquals($data['total_products'], $created->total_products);
        $this->assertEquals($data['total_paid'], $created->total_paid);
        $this->assertEquals($data['invoice'], $created->invoice);
    }
}
