<?php

declare(strict_types=1);

namespace App\Livewire\Property\Room;

use App\Models\DefaultRoom;
use App\Models\Property;
use App\Models\Room;
use App\Services\PropertyService;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Index extends Component
{
    public Property $property;

    public $rooms = [];
    
    public Room $activeRoom;
    
    protected $listeners = [
        'new-room-created' => '$refresh',
        'room-deleted' => '$refresh',
        'room-updated' => '$refresh',
    ];

    public function render(): Factory|View
    {
        return view('livewire.property.room.index');
    }

    public function mount(Property $property): void
    {
        $this->property = $property;
        $this->fetchRooms();
    }

    public function setActiveRoom(Room $room): void
    {
        $this->activeRoom = $room;
        Flux::modal('confirm-room-deletion')->show();
    }

    public function attachDefaultRooms()
    {
        DefaultRoom::all()
            ->each(fn ($room) => $this->property->rooms()->create(
                $room->only('name')
            ));
        $this->fetchRooms();
    }

    public function fetchRooms(): void
    {
        $propertyService = new PropertyService();
        $this->rooms = $propertyService->getRoomsForProperty($this->property);
    }
}
