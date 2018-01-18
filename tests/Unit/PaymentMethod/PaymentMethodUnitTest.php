<?php

namespace Tests\Unit\PaymentMethod;

use App\Shop\PaymentMethods\Exceptions\PaymentMethodInvalidArgumentException;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodNotFoundException;
use App\Shop\PaymentMethods\PaymentMethod;
use App\Shop\PaymentMethods\Repositories\PaymentMethodRepository;
use ErrorException;
use Tests\TestCase;

class PaymentMethodUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_updating_a_payment_method()
    {
        $this->expectException(PaymentMethodInvalidArgumentException::class);

        $payment = new PaymentMethodRepository($this->paymentMethod);
        $payment->updatePaymentMethod(['name' => null]);
    }
    
    /** @test */
    public function it_can_list_all_the_payment_methods()
    {
        $data = [
            'name' => $this->faker->word,
            'slug' => str_slug($this->faker->word),
            'description' => $this->faker->paragraph
        ];

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $payment->createPaymentMethod($data);
        $lists = $payment->listPaymentMethods();

        foreach ($lists as $list) {
            $this->assertDatabaseHas('payment_methods', ['name' => $list->name]);
            $this->assertDatabaseHas('payment_methods', ['description' => $list->description]);
        }
    }
    
    /** @test */
    public function it_errors_when_the_payment_method_is_not_found()
    {
        $this->expectException(PaymentMethodNotFoundException::class);

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $payment->findPaymentMethodById(999);
    }

    /** @test */
    public function it_can_get_the_payment_method()
    {
        $data = [
            'name' => $this->faker->sentence,
            'slug' => str_slug($this->faker->word),
            'description' => $this->faker->paragraph
        ];

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $method = $payment->createPaymentMethod($data);

        $payment->findPaymentMethodById($method->id);

        $this->assertEquals($data['name'], $method->name);
        $this->assertEquals($data['description'], $method->description);
    }

    /** @test */
    public function it_can_update_the_payment_method()
    {
        $payment = new PaymentMethodRepository($this->paymentMethod);

        $update = [
            'name' => $this->faker->sentence,
            'slug' => str_slug($this->faker->word),
            'description' => $this->faker->paragraph
        ];

        $updated = $payment->updatePaymentMethod($update);

        $this->assertEquals($update['name'], $updated->name);
        $this->assertEquals($update['description'], $updated->description);
    }
    
    /** @test */
    public function it_errors_when_creating_the_payment_method_if_the_required_fields_are_not_passed()
    {
        $this->expectException(ErrorException::class);

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $payment->createPaymentMethod([]);
    }
    
    /** @test */
    public function it_can_create_a_payment()
    {
        $name = $this->faker->word;
        $data = [
            'name' => $name,
            'slug' => str_slug($name),
            'description' => $this->faker->paragraph
        ];

        $payment = new PaymentMethodRepository(new PaymentMethod);
        $method = $payment->createPaymentMethod($data);

        $this->assertEquals($data['name'], $method->name);
        $this->assertEquals($data['description'], $method->description);
    }
}
