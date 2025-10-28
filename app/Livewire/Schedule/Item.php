<?php

declare(strict_types=1);

namespace App\Livewire\Schedule;

use App\Enums\ScheduleStatus;
use App\Models\Schedule;
use App\Models\Task;
use App\Services\ScheduleService;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Item extends Component
{
    use WithFileUploads;

    public Schedule $schedule;

    #[Validate(['images.*' => 'image|max:5000'])]
    public $images = [];

    #[Validate('nullable|max:1000')]
    public string $notes = '';

    private ScheduleService $scheduleService;

    public Task $activeTask;

    public function __construct()
    {
        $this->scheduleService = new ScheduleService;
    }

    public function mount(Schedule $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function startCleaning(array $data): void
    {
        $this->schedule->update([
            'status' => ScheduleStatus::IN_PROGRESS,
        ]);
    }

    public function setActiveTask(Task $task): void
    {
        $this->activeTask = $task;
    }

    public function createChecklist(): void
    {
        $this->scheduleService->markTaskAsDone(
            $this->activeTask,
            $this->images,
            $this->notes,
        );

        Flux::modal('create-checklist')->close();
    }

    public function render(): Factory|View
    {
        return view('livewire.schedule.item');
    }
}
