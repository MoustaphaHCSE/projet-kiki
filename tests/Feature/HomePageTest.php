<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_homepage_contains_specific_text(): void
    {
        $response = $this->get('/');
        $response->assertSee("Welcome to Projet Kiki");
        $response->assertStatus(200);
    }
}
