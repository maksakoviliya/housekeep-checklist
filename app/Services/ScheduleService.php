<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ScheduleStatus;
use App\Models\Property;
use App\Models\Schedule;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Collection;


final class ScheduleService
{
    public function create(Property $property, User $housekeeper, DateTime $scheduledAt)
    {
        return Schedule::query()
            ->create([
                'property_id' => $property->id,
                'user_id' => $housekeeper->id,
                'scheduled_at' => $scheduledAt->format('Y-m-d H:i:s'),
                'status' => ScheduleStatus::PENDING,
            ]);
    }

    public function formatForCalendar(Collection $schedule): array
    {
        return $schedule->load('housekeeper')->map(function (Schedule $item) {
            $color = $item->status->color();
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'title' => $item->housekeeper->name,
                'start' => $item->scheduled_at,
                'status' => $item->status->value,
                'display' => 'block',
                'borderColor' => $color,
                'backgroundColor' => $color,
                'date' => $item->scheduled_at->format('d.m.Y'),
            ];
        })->toArray();
    }
}