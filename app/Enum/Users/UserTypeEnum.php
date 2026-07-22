<?php

namespace App\Enum\Users;

enum UserTypeEnum:string
{
    case CUSTOMER = 'customer';
    case ADMIN = 'admin';
    case VENDOR = 'vendor';
}
