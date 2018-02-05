<?php

namespace Tests\Feature\Admin\Dashboard;

use Tests\TestCase;

class DashboardFeatureTest extends TestCase 
{
    /** @test */
    public function it_can_show_the_dashboard()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.dashboard'))
            ->assertStatus(200);
    }
}