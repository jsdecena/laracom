<?php

namespace Tests\Feature\Front\Accounts;

use App\Shop\Customers\Customer;
use Illuminate\Auth\Events\Lockout;
use Tests\TestCase;

class FrontAccountsFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_reset_password_page()
    {
        $this->get(route('password.reset', $this->faker->uuid))
            ->assertStatus(200);
    }

    /** @test */
    public function it_throws_validation_error_during_registration()
    {
        $this->post(route('register'), [])
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_register_the_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $this->post(route('register'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('accounts'));
    }
    
    /** @test */
    public function it_can_show_the_registration_page()
    {
        $this->get(route('register'))
            ->assertStatus(200)
            ->assertSee('Name')
            ->assertSee('E-Mail Address')
            ->assertSee('Password')
            ->assertSee('Confirm Password');
    }

    /** @test */
    public function it_shows_the_password_reset_page()
    {
        $this->get(route('password.request'))
            ->assertStatus(200)
            ->assertSee('E-Mail Address')
            ->assertSee('Send Password Reset Link')
            ->assertSee('Reset Password');
    }

    /** @test */
    public function it_shows_the_login_form()
    {
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('Login now')
            ->assertSee('I forgot my password')
            ->assertSee('No account? Register here.');
    }

    /** @test */
    public function it_shows_the_account_page_after_successful_login()
    {
        $this
            ->post(route('login'), ['email' => $this->customer->email, 'password' => 'secret'])
            ->assertStatus(302)
            ->assertRedirect(route('accounts', ['tab' => 'profile']));
    }

    /** @test */
    public function it_throws_the_too_many_login_attempts_event()
    {
        $this->expectsEvents(Lockout::class);

        $customer = factory(Customer::class)->create();

        for ($i=0; $i <= 5; $i++) {
            $data = [
                'email' => $customer->email,
                'password' => 'unknown'
            ];

            $this->post(route('login'), $data);
        }
    }

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
            ->assertRedirect(route('accounts', ['tab' => 'profile']));
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
