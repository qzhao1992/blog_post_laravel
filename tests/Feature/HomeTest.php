<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsWorking()
    {
        $user = $this->user();
        $this->actingAs($user);
        $response = $this->get('/');

        $response->assertSeeText('Hello world');
    }

    public function testContactPageIsWorking()
    {
        $user = $this->user();
        $this->actingAs($user);
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
    }


}
