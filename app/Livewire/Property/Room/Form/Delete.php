<?php

declare(strict_types=1);

namespace App\Livewire\Property\Room\Form;

use App\Models\Room;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Delete extends Component
{
    public Room $room;

    public function mount(Room $room): void
    {
        $this->room = $room;
    }

    public function deleteRoomConfirmation(): void
    {
        Flux::modal('confirm-room-deletion')->close();
        $this->room->delete();
        $this->dispatch('room-deleted');
    }

    public function render(): Factory|View
    {
        return view('livewire.property.room.form.delete');
    }
}
