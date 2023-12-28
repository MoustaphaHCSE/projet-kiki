<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function store(array $userData): User
    {
        $userData['password'] = Hash::make($userData['password']);
        $user = User::create($userData);
        $user->assignRole($userData['roles']);

        return $user;
    }
}