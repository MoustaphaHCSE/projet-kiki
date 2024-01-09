<?php

namespace App\Actions;

use App\Enums\Action;
use App\Enums\RoleEnum;
use App\Enums\UserStatus;
use App\Models\User;

class CheckUserUpdatableAction
{
    public function __invoke(User $user, $action): UserStatus
    {
        if ($action == Action::DESTROY && ($user->hasRole(RoleEnum::SUPER_ADMIN) || $user->id == auth()->user()->id)) {
            return UserStatus::NotDeletable;
        }
        if ($action == Action::EDIT && $user->hasRole(RoleEnum::SUPER_ADMIN) && $user->id != auth()->user()->id) {
            return UserStatus::NotUpdatable;
        }
        return UserStatus::UPDATABLE;
    }
}
