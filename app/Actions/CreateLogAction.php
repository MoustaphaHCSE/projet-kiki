<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;

class CreateLogAction
{
    public function __invoke($route, $message, $target): void
    {
        $user = auth()->user()->name;
        $userId = auth()->user()->id;
//        informs that the actual user is acting on target user's id
        Log::channel($route)->info(sprintf('%s (id : %s) - %s on user : %s', $user, $userId, $message, $target));
    }
}
