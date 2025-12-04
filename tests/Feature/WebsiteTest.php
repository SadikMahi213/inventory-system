<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_access_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_access_media_page()
    {
        $response = $this->get('/media');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_access_contact_page()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }
}