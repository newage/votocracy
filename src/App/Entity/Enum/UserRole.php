<?php

namespace App\Entity\Enum;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
