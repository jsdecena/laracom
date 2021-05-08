<?php

namespace Tests\Feature\Front\Checkout;

use Tests\TestCase;

class CheckoutFeatureTest extends TestCase
{
    /** @test */
    public function it_fails_validation_in_preparing_stripe_checkout_items()
    {
        $this
            ->actingAs($this->customer, 'web')
            ->post(route('checkout.execute', []))
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function it_fails_validation_in_preparing_payPal_checkout_items()
    {
        $this
            ->actingAs($this->customer, 'web')
            ->get(route('checkout.execute', []))
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }
}
