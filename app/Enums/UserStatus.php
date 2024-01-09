<?php

namespace App\Enums;

enum UserStatus: int
{
    case UPDATABLE = 1;

    case NotUpdatable = 2;

    case NotDeletable = 3;
}
