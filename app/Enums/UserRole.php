<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';

    case USER = 'user';

    case HOUSEKEEPER = 'housekeeper';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => __('Admin'),
            self::USER => __('User'),
            self::HOUSEKEEPER => __('Housekeeper'),
        };
    }
}
