<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\DefaultRoom;
use App\Models\Room;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Rooms extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';
    
    public DefaultRoom $activeRoom;

    #[Computed]
    public function defaultRooms(): Collection
    {
        return DefaultRoom::query()->get();
    }

    public function createRoom(): void
    {
        $this->validate();
        
        DefaultRoom::query()->create([
            'name' => $this->name,
        ]);
        
        $this->name = '';
        Flux::modal('create-default-room')->close();
    }

    public function setActiveRoom(DefaultRoom $room): void
    {
        $this->activeRoom = $room;
    }

    public function deleteRoom()
    {
        $this->activeRoom->delete();
        Flux::modal('confirm-default-room-deleting')->close();
    }
    
    public function render(): Factory|View
    {
        return view('livewire.admin.rooms');
    }
}
