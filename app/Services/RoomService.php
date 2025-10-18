<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Room;

final readonly class RoomService
{
    public function updateRoom(Room $room, array $data): Room
    {
        $room->update([
            'name' => $data['name'],
        ]);

        return $room->refresh();
    }
}
