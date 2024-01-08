<?php

namespace App\Actions;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckUserUpdatableAction
{
    public function __invoke(User $user, $action): HttpException
    {
        if ($action == "destroy" && ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)) {
            return abort(403, 'TU PEUX NI TE SUPPRIMER NI SUPPRIMER UN SUPER ADMIN');
        }
        if ($action == "edit" && $user->hasRole('Super Admin') && $user->id != auth()->user()->id) {
            return abort(403, 'UN SUPER ADMIN NE PEUT EN MODIFIER UN AUTRE');
        }
        return new HttpException(200, "L'utilisateur peut être modifié.");
    }
}
