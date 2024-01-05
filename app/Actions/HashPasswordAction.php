<?php

namespace App\Actions;

use Illuminate\Support\Facades\Hash;

class HashPasswordAction
{
    public function __invoke($password): string
    {
        return Hash::make($password);
    }
}
