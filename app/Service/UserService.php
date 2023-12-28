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

    public function edit(User $user): User
    {
        // Assure that only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'A SUPER ADMIN CAN\'T UPDATE ANOTHER SUPER ADMIN');
            }
        }
        return $user;
    }
}