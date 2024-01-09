<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = "super_admin";

    case ADMIN = "admin";

    case CELEBRITY_MANAGER = "celebrity_manager";

    case USER = "user";

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => "Super Admin",
            self::ADMIN => "Admin",
            self::CELEBRITY_MANAGER => "Celebrity Manager",
            self::USER => "User",
        };
    }
}
