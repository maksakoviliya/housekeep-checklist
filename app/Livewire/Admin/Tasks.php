<?php

namespace App\Livewire\Admin;

use App\Models\DefaultTask;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Tasks extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    public DefaultTask $activeTask;

    #[Computed]
    public function defaultTasks(): Collection
    {
        return DefaultTask::query()->get();
    }

    public function createTask(): void
    {
        $this->validate();

        DefaultTask::query()->create([
            'name' => $this->name,
        ]);

        $this->name = '';
        Flux::modal('create-default-task')->close();
    }

    public function setActiveTask(DefaultTask $task): void
    {
        $this->activeTask = $task;
    }

    public function deleteTask(): void
    {
        $this->activeTask->delete();
        Flux::modal('confirm-default-task-deleting')->close();
    }

    public function render(): Factory|View
    {
        return view('livewire.admin.tasks');
    }
}
