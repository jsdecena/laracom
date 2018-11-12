<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtisanCommands extends TestCase
{
    /** @test */
    public function it_can_generate_files()
    {
	    $this->artisan('make:structure Test')
	    	->expectsOutput('File structure for Test created.')
	    	->assertExitCode();
    }
}
