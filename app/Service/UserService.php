<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Arr;
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

    public function update(array $userData, User $user): User
    {
        if (!empty($request->password)) {
            $userData['password'] = Hash::make($userData['password']);
        } else {
            $userData = Arr::except($userData, 'password');
        }
        $user->update($userData);

        $user->syncRoles($userData['roles']);
        return $user;
    }

    public function destroy(User $user): User
    {
        // Check if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'CAN\'T DELETE THIS USER (it\'s either you or an admin');
        }
        $user->syncRoles([]);
        $user->delete();
        return $user;
    }
}