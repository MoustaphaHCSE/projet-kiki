<?php

namespace App\Actions;

use App\Enums\Action;
use App\Enums\RoleEnum;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckUserUpdatableAction
{
    public function __invoke(User $user, $action): HttpException
    {
        if ($action == Action::DESTROY && ($user->hasRole(RoleEnum::SUPER_ADMIN) || $user->id == auth()->user()->id)) {
            abort(403, 'TU PEUX NI TE SUPPRIMER NI SUPPRIMER UN SUPER ADMIN');
        }
        if ($action == Action::EDIT && $user->hasRole(RoleEnum::SUPER_ADMIN) && $user->id != auth()->user()->id) {
            abort(403, 'UN SUPER ADMIN NE PEUT EN MODIFIER UN AUTRE');
        }
        return new HttpException(200, "L'utilisateur peut être modifié.");
    }
}
