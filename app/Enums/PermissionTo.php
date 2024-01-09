<?php

namespace App\Enums;

enum PermissionTo: string
{
    case CREATE_USER = "create-user";

    case EDIT_USER = "edit-user";

    case DELETE_USER = "delete-user";

    case CREATE_CELEBRITY = "create-celebrity";

    case EDIT_CELEBRITY = "edit-celebrity";

    case DELETE_CELEBRITY = "delete-celebrity";

    case CREATE_ROLE = "create-role";

    case EDIT_ROLE = "edit-role";

    case DELETE_ROLE = "delete-role";

//    apply to middlewares only
    case CRUD_USER = "permission:create-user|edit-user|delete-user";
    case CRUD_CELEBRITY = "permission:create-celebrity|edit-celebrity|delete-celebrity";
    case CRUD_ROLE = "permission:create-role|edit-role|delete-role";

    /**
     * @return string returns with the 'permission:' prefix, for middlewares
     */
    public function label(): string
    {
        return match ($this) {
            self::CREATE_USER => "permission:create-user",
            self::EDIT_USER => "permission:edit-user",
            self::DELETE_USER => "permission:delete-user",
            self::CREATE_CELEBRITY => "permission:create-celebrity",
            self::EDIT_CELEBRITY => "permission:edit-celebrity",
            self::DELETE_CELEBRITY => "permission:delete-celebrity",
            self::CREATE_ROLE => "permission:create-role",
            self::EDIT_ROLE => "permission:edit-role",
            self::DELETE_ROLE => "permission:delete-role",
            self::CRUD_USER => "permission:create-user|edit-user|delete-user",
            self::CRUD_CELEBRITY => "permission:create-celebrity|edit-celebrity|delete-celebrity",
            self::CRUD_ROLE => "permission:create-role|edit-role|delete-role",
        };
    }
}
