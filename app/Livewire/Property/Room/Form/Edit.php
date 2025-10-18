<?php

namespace App\Livewire\Property\Room\Form;

use App\Models\Property;
use App\Models\Room;
use App\Services\PropertyService;
use App\Services\RoomService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public Property $property;

    public Room $room;

    #[Validate('required|string|max:255')]
    public string $name = '';

    private RoomService $roomService;

    public function __construct()
    {
        $this->roomService = new RoomService();
    }

    public function mount(Property $property, Room $room): void
    {
        $this->property = $property;
        $this->room = $room;
        $this->name = $room->name;
    }

    public function submit(): void
    {
        $this->validate();

        $this->roomService->updateRoom($this->room, [
            'name' => $this->name,
        ]);

        $this->dispatch('room-updated');
    }

    public function render(): Factory|View
    {
        return view('livewire.property.room.form.edit');
    }
}
