<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function hashPassword($data): void
    {
        $data['password'] = Hash::make($data['password']);
    }

    public function createUser($data): User
    {
        return User::create($data);
    }

    public function assignRole($data, User $user): void
    {
        $user->assignRole($data['roles']);
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
