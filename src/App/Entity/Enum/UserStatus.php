<?php

namespace App\Entity\Enum;

enum UserStatus: string
{
    case UNCONFIRMED = 'unconfirmed';
    case CONFIRMED = 'confirmed';
    case DISABLED = 'disabled';
}
