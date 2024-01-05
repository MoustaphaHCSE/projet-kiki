<?php

namespace App\Service;

use App\Actions\CreateLogAction;
use App\Actions\HashPasswordAction;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function store($data): User
    {
        $data['password'] = app()->call(HashPasswordAction::class, [
            'password' => $data['password']
        ]);
        $user = User::create($data);
        $user->assignRole($data['roles']);
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => 'Adding a new user',
        ]);
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

    public function createUserLogs($message)
//créer une action createLogs qui prend la route + le message en param et utiliser partout
    {
        Log::channel('user-crud')->info($message);
    }
}
