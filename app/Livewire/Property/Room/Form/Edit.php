<?php

declare(strict_types=1);

namespace App\Livewire\Property\Room\Form;

use App\Models\Property;
use App\Models\Room;
use App\Models\Task;
use App\Services\RoomService;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Edit extends Component
{
    public Property $property;

    public Room $room;

    #[Validate('required|string|max:255')]
    public string $name = '';

    public ?string $deletingTaskId = null;

    protected $listeners = [
        'task-created' => '$refresh',
        'task-deleted' => '$refresh',
        'confirm-task-deleting' => 'setDeletingTaskId',
        'task-deleting-confirmed' => 'submitDeleting',
    ];

    public function mount(Property $property, Room $room): void
    {
        $this->property = $property;
        $this->room = $room;
        $this->name = $room->name;
    }

    public function submit(RoomService $roomService): void
    {
        $this->validate();

        $roomService->updateRoom($this->room, [
            'name' => $this->name,
        ]);

        $this->dispatch('room-updated');
    }

    #[Computed]
    public function tasks(): Collection
    {
        return $this->room->tasks()->latest()->get();
    }

    public function setDeletingTaskId(string $taskId): void
    {
        $this->deletingTaskId = $taskId;
    }

    public function submitDeleting(): void
    {
        Flux::modal('confirm-task-deletion')->close();

        if (! $this->deletingTaskId) {
            return;
        }

        $deletingTask = Task::query()->find($this->deletingTaskId);
        if (! $deletingTask) {
            return;
        }

        $deletingTask->delete();
    }

    public function render(RoomService $roomService): View
    {
        return view('livewire.property.room.form.edit', [
            'tasks' => $this->tasks,
        ]);
    }
}
