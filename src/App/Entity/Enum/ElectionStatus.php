<?php

namespace App\Entity\Enum;

enum ElectionStatus: string
{
    case PREPARING = 'preparing';
    case VOTING = 'voting';
    case ENDED = 'ended';
    case CANCELED = 'canceled';
}
