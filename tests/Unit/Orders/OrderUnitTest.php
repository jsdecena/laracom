<?php

namespace Tests\Unit\Orders;

use App\Addresses\Address;
use App\Couriers\Courier;
use App\Customers\Customer;
use App\Events\OrderCreateEvent;
use App\Mail\sendEmailNotificationToAdminMailable;
use App\Mail\SendOrderToCustomerMailable;
use App\Orders\Exceptions\OrderInvalidArgumentException;
use App\Orders\Exceptions\OrderNotFoundException;
use App\Orders\Order;
use App\Orders\Repositories\OrderRepository;
use App\OrderStatuses\OrderStatus;
use App\PaymentMethods\PaymentMethod;
use App\Products\Product;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderUnitTest extends TestCase
{
    /** @test */
    public function it_can_send_email_to_customer()
    {
        Mail::fake();

        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();
        $paymentMethod = factory(PaymentMethod::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment_method_id' => $paymentMethod->id,
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
    public function it_can_update_the_product_quanity_upon_creation_of_order_details()
    {
        $product = factory(Product::class)->create(['quantity' => 9]);
        $order = factory(Order::class)->create();

        $orderRepo = new OrderRepository($order);
        $orderRepo->associateProduct($product);

        $this->assertEquals(9, $product->quantity);
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
        $paymentMethod = factory(PaymentMethod::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment_method_id' => $paymentMethod->id,
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $this->expectsEvents(OrderCreateEvent::class);

        $orderRepo = new OrderRepository(new Order);
        $orderRepo->createOrder($data);

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
        $this->expectExceptionMessage('Order not found.');

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
        $paymentMethod = factory(PaymentMethod::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment_method_id' => $paymentMethod->id,
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
        $paymentMethod = factory(PaymentMethod::class)->create();

        $update = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment_method_id' => $paymentMethod->id,
            'discounts' => 10.50,
            'total_products' =>  100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $updated = $orderRepo->updateOrder($update);

        $this->assertEquals($update['reference'], $updated->reference);
        $this->assertEquals($update['discounts'], $updated->discounts);
        $this->assertEquals($update['total_products'], $updated->total_products);
        $this->assertEquals($update['total_paid'], $updated->total_paid);
        $this->assertEquals($update['invoice'], $updated->invoice);
    }

    /** @test */
    public function it_errors_when_the_required_fields_are_not_passed()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $customer = factory(Customer::class)->create();
        $courier = factory(Courier::class)->create();
        $address = factory(Address::class)->create();
        $orderStatus = factory(OrderStatus::class)->create();
        $paymentMethod = factory(PaymentMethod::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment_method_id' => $paymentMethod->id,
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
        $paymentMethod = factory(PaymentMethod::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment_method_id' => $paymentMethod->id,
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
        $paymentMethod = factory(PaymentMethod::class)->create();

        $data = [
            'reference' => $this->faker->uuid,
            'courier_id' => $courier->id,
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $orderStatus->id,
            'payment_method_id' => $paymentMethod->id,
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