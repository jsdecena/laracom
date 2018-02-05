<?php

namespace Tests\Feature\Front\Home;

use App\Shop\Categories\Category;
use Tests\TestCase;

class HomeFeatureTest extends TestCase
{
    /** @test */
    public function it_should_show_the_homepage()
    {
        factory(Category::class, 3)->create();

        $this
            ->get(route('home'))
            ->assertStatus(200);
    }
}