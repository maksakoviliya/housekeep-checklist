<?php

namespace App\Enums;

enum PropertyOwnership: string
{
    case OWNER = 'owner';

    case HOUSEKEEPER = 'housekeeper';
}
