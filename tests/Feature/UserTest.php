<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_ok_on_users_index_page(): void
    {
        $response = $this->get('/admin/users');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
