<?php

namespace Tests\Feature;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_if_not_logged_in(): void
    {
        $response = $this->get('/admin/celebrities');
        $response->assertRedirect('login');
    }

    public function test_user_cannot_access_non_existent_celebrity_with_session(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['deleted' => false])
            ->get('/admin/celebrities/1');
        $response->assertStatus(404);
    }

    public function test_user_can_access_celebrity_with_session(): void
    {
        $user = User::factory()->create();
        $celebrity = Celebrity::factory()->createOne();

        $response = $this->actingAs($user)
            ->get('/admin/celebrities/' . $celebrity->id);

        $response->assertStatus(200);
    }
}
