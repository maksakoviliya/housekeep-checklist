<?php

namespace App\Enums;

enum ScheduleStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'orange',
            self::IN_PROGRESS => 'blue',
            self::COMPLETED => 'green',
        };
    }
}