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
}