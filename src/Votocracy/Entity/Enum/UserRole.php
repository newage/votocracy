<?php

namespace Votocracy\Entity\Enum;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
