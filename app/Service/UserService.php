<?php

namespace App\Service;

use App\Actions\CheckUserUpdatableAction;
use App\Actions\CreateLogAction;
use App\Actions\HashPasswordAction;
use App\Enums\Action;
use App\Models\User;
use Illuminate\Support\Arr;

class UserService
{
    public function displayUsers(): void
    {
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => 'displaying all users',
        ]);
    }

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

    public function create(): void
    {
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => 'Creating a new user',
        ]);
    }

    public function show(User $user): void
    {
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('Showing user: %s \'s profile', $user->id),
        ]);

    }

    public function edit(User $user): void
    {
        app()->call(CheckUserUpdatableAction::class, [
            'user' => $user,
            'action' => Action::EDIT
        ]);
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('User: %s\'s profile is being edited', $user->id),
        ]);
    }

    public function update(array $userData, User $user): User
    {
        if (!empty($request->password)) {
            $userData['password'] = app()->call(HashPasswordAction::class, [
                'password' => $userData['password']
            ]);
        }
        $userData = Arr::except($userData, 'password');
        $user->update($userData);
        $user->syncRoles($userData['roles']);

        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('Update on user: %s', $user->id),
        ]);
        return $user;
    }

    public function destroy(User $user): User
    {
        app()->call(CheckUserUpdatableAction::class, [
            'user' => $user,
            'action' => Action::DESTROY,
        ]);
        $user->syncRoles([]);
        $user->delete();
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('Delete user: %s', $user->id),
        ]);
        return $user;
    }
}
