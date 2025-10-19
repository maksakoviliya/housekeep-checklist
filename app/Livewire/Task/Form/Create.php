<?php

declare(strict_types=1);

namespace App\Livewire\Task\Form;

use App\Livewire\Property\Room\Form\Edit;
use App\Models\Room;
use App\Services\TaskService;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Create extends Component
{
    #[Validate('required|string|max:1000')]
    public string $task = '';
    
    private TaskService $taskService;
    
    public Room $room;
    
    public function __construct()
    {
        $this->taskService = new TaskService;
    }

    public function mount(Room $room): void
    {
        $this->room = $room;
    }

    public function render(): Factory|View
    {
        return view('livewire.task.form.create');
    }
    
    public function submit(): void
    {
        $this->validate();

        $task = $this->taskService->createTask([
            'task' => $this->task,
        ], $this->room);

        $this->dispatch('task-created', $task);
        Flux::modal('add-task')->close();

        $this->task = '';
    }
}
