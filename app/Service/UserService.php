<?php

namespace App\Service;

use App\Actions\CreateLogAction;
use App\Actions\HashPasswordAction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserService
{
    public function displayUsers(): View
    {
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => 'displaying all users',
        ]);
        return view('users.index', [
            'users' => User::latest('id')->paginate(4)
        ]);
    }

    public function store($data): RedirectResponse
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
        return redirect()->route('users.index')
            ->with('success', 'Nouvel utilisateur ajouté.');
    }

    public function create(): View
    {
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => 'Creating a new user',
        ]);

        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    public function show(User $user): View
    {
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('Showing user: %s \'s profile', $user->id),
        ]);
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user): View
    {
        // Assure that only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'A SUPER ADMIN CAN\'T UPDATE ANOTHER SUPER ADMIN');
            }
        }
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('User: %s\'s profile is being edited', $user->id),
        ]);
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    public function update(array $userData, User $user): RedirectResponse
    {
        if (!empty($request->password)) {
            $userData['password'] = Hash::make($userData['password']);
        } else {
            $userData = Arr::except($userData, 'password');
        }
        $user->update($userData);

        $user->syncRoles($userData['roles']);

        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('Update on user: %s', $user->id),
        ]);
        return redirect()->route('users.index')
            ->with('success', 'User is updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Check if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'CAN\'T DELETE THIS USER (it\'s either you or an admin');
        }
        $user->syncRoles([]);
        $user->delete();
        app()->call(CreateLogAction::class, [
            'route' => 'user-crud',
            'message' => sprintf('Delete user: %s', $user->id),
        ]);
        return redirect()->route('users.index')
            ->with('success', 'User is deleted successfully.');
    }
}
