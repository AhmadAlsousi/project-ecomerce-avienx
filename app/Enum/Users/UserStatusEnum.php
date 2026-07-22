<?php

namespace App\Enum\Users;

enum UserStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
    case BLOCKED='blocked';
}
