<?php

namespace App\Actions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckUserUpdatableAction
{
    public function __invoke($user, $action): HttpException
    {
        if ($action == "destroy" && ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)) {
            return abort(403, 'TU PEUX NI TE SUPPRIMER NI SUPPRIMER UN SUPER ADMIN');
        }
        if ($action == "edit" && $user->hasRole('Super Admin') && $user->id != auth()->user()->id) {
            return abort(403, 'A SUPER ADMIN CAN\'T UPDATE ANOTHER SUPER ADMIN');
        }
        return new HttpException(200, "User can be updated");
    }
}
