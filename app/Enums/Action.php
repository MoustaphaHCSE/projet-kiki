<?php

namespace App\Enums;

enum Action: string
{
    case CREATE = 'create';

    case SHOW = 'show';

    case EDIT = 'edit';

    case UPDATE = 'update';

    case DELETE = 'delete';

    case DESTROY = 'destroy';
}
