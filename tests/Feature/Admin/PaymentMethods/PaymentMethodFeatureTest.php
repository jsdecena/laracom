<?php

namespace Tests\Feature\Admin\PaymentMethods;

use App\Shop\PaymentMethods\PaymentMethod;
use Tests\TestCase;

class PaymentMethodFeatureTest extends TestCase
{
    /** @test */
    public function it_can_delete_the_payment_method()
    {
        $paymentMethod = factory(PaymentMethod::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->delete(route('admin.payment-methods.destroy', $paymentMethod->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.payment-methods.index'))
            ->assertSessionHas('message', 'Delete successful');
    }

    /** @test */
    public function it_can_show_the_payment_method_create_and_edit_page()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.payment-methods.create'))
            ->assertStatus(200);

        $paymentMethod = factory(PaymentMethod::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.payment-methods.edit', $paymentMethod->id))
            ->assertStatus(200)
            ->assertSee(htmlentities($paymentMethod->name, ENT_QUOTES))
            ->assertSee(htmlentities($paymentMethod->description, ENT_QUOTES));
    }
    
    /** @test */
    public function it_can_list_all_payment_methods()
    {
        $paymentMethod = factory(PaymentMethod::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.payment-methods.index'))
            ->assertStatus(200)
            ->assertSee(htmlentities($paymentMethod->name, ENT_QUOTES));
    }
    
    /** @test */
    public function it_can_update_the_payment_method()
    {
        $paymentMethod = factory(PaymentMethod::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->put(route('admin.payment-methods.update', $paymentMethod->id), $this->paymentMethodData())
            ->assertStatus(302)
            ->assertRedirect(route('admin.payment-methods.edit', $paymentMethod->id))
            ->assertSessionHas('message');
    }

    /** @test */
    public function it_can_create_a_payment_method()
    {
         $this
             ->actingAs($this->employee, 'admin')
             ->post(route('admin.payment-methods.store'), $this->paymentMethodData())
             ->assertStatus(302)
             ->assertRedirect(route('admin.payment-methods.index'))
             ->assertSessionHas('message');
    }

    public function paymentMethodData()
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
            'account_id' => $this->faker->word,
            'client_id' => $this->faker->word,
            'client_secret' => $this->faker->word
        ];
    }
}