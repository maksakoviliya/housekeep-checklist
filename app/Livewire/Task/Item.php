<?php

declare(strict_types=1);

namespace App\Livewire\Task;

use App\Models\Task;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Item extends Component
{
    public Task $task;
    
    public function mount(Task $task): void
    {
        $this->task = $task;
    }

    public function confirmDeleting(): void
    {
        $this->dispatch('confirm-task-deleting', $this->task->id);
    }
    
    public function render(): Factory|View
    {
        return view('livewire.task.item');
    }
}
