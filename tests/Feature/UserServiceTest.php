<?php

namespace Tests\Feature;

use App\Service\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
//sail artisan test --filter UserServiceTest
    public function test_database_has_specific_user(): void
    {
        $this->assertDatabaseHas('users', [
            "email" => "carter@admin.com"
        ]);
    }

    public function test_user_service_performs_crud(): void
    {
        $userService = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userData = [
            "name" => "carter",
            "email" => "carter15631531531@gmail.com",
            "password" => "123123123",
        ];
        $user = $userService->store($userData);
//        not asserted
    }
}
