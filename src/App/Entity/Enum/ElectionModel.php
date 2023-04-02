<?php

namespace App\Entity\Enum;

enum ElectionModel: string
{
    case CONDORCED = 'condorced';
    case BORDA = 'borda';
    case SCHULZE = 'schulze';
    case AUTO_ONE = 'auto_one';
    case AUTO_RATING = 'auto_rating';
}
