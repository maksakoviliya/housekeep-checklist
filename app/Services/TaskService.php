<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Room;
use App\Models\Task;
use Illuminate\Support\Arr;

final readonly class TaskService
{
    public function createTask(array $data, Room $room)
    {
        return Task::query()->create([
            'property_id' => $room->property_id,
            'room_id' => $room->id,
            'task' => Arr::get($data, 'task'),
        ]);
    }
}
