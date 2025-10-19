<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ScheduleStatus;
use App\Enums\UserRole;
use App\Models\Property;
use App\Models\Schedule;
use App\Models\Task;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;


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
            /** @var User $user */
            $user = Auth::user();
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'property_id' => $item->property_id,
                'title' => $user->role === UserRole::HOUSEKEEPER ? $item->property->name : $item->housekeeper->name,
                'start' => $item->scheduled_at,
                'status' => $item->status->value,
                'display' => 'block',
                'borderColor' => $color,
                'backgroundColor' => $color,
                'date' => $item->scheduled_at->format('d.m.Y'),
            ];
        })->toArray();
    }

    public function markTaskAsDone(Task $task, array $images, string $notes = ''): void
    {
        $task->checklist()->create([
            'user_id' => Auth::id(),
            'started_at' => now(),
            'property_id' => $task->property_id,
            'room_id' => $task->room_id,
            'finished_at' => now(),
            'is_checked' => true,
            'notes' => $notes,
            'image' => !empty($images) ? json_encode(array_map(fn ($image) => $image->store('checklist_images', 'public'), $images)) : null,
        ]);
    }
}