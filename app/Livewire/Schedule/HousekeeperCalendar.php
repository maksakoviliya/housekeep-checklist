<?php

declare(strict_types=1);

namespace App\Livewire\Schedule;

use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class HousekeeperCalendar extends Component
{
    public Collection $schedule;

    private ScheduleService $scheduleService;

    public function __construct()
    {
        $this->scheduleService = new ScheduleService;
    }

    public function mount(): void
    {
        $this->schedule = $this->fetchSchedule();
    }

    private function fetchSchedule(): Collection
    {
        return Schedule::query()
            ->where('user_id', Auth::id())
            ->get();
    }

    public function setEvent($data): void
    {
        $this->redirect(route('properties.schedule.view', [
            'property' => Arr::get($data, 'event.extendedProps.property_id'),
            'schedule' => Arr::get($data, 'event.id'),
        ]));
    }

    public function render(): Factory|View
    {
        $this->dispatch('init-calendar', [
            'schedule' => $this->scheduleService->formatForCalendar($this->schedule),
        ]);

        return view('livewire.schedule.housekeeper-calendar');
    }
}
