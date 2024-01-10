<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CelebrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_non_existent_celebrity_with_session(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/admin/celebrities/1');
        $response->assertStatus(404);
    }
}
