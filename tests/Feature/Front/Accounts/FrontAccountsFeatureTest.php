<?php

namespace Tests\Feature\Front\Accounts;

use App\Shop\Customers\Customer;
use Tests\TestCase;

class FrontAccountsFeatureTest extends TestCase 
{
    /** @test */
    public function it_can_show_the_user_account()
    {
        $this
            ->actingAs($this->customer, 'web')
            ->get(route('accounts'))
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_go_to_my_accounts_page_on_successful_login()
    {
        $customer = factory(Customer::class)->create();

        $data = [
            'email' => $customer->email,
            'password' => 'secret'
        ];

        $this->post(route('login'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('accounts'));
    }

    /** @test */
    public function it_errors_when_the_customer_is_logging_in_without_the_email_or_password()
    {
        $this
            ->post('login', [])
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
                'password' => 'The password field is required.'
            ]);
    }
}