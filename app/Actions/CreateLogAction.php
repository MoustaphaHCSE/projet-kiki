<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;

class CreateLogAction
{
    public function __invoke($route, $message)
    {
        Log::channel($route)->info($message);
    }
}
