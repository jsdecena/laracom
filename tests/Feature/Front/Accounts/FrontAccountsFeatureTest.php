<?php

namespace Tests\Feature\Front\Accounts;

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
}