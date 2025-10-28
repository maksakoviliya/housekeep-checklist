<?php

declare(strict_types=1);

namespace App\Livewire\Schedule;

use App\Models\Property;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Calendar extends Component
{
    public Property $property;

    public Collection $schedule;

    private ScheduleService $scheduleService;

    public function __construct()
    {
        $this->scheduleService = new ScheduleService;
    }

    public function mount(Property $property): void
    {
        $this->property = $property;
        $this->schedule = $this->fetchSchedule();
    }

    protected $listeners = [
        'schedule-created' => 'refreshSchedule',
    ];

    private function fetchSchedule(): Collection
    {
        return Schedule::query()
            ->where('property_id', $this->property->id)
            ->get();
    }

    public function render(): Factory|View
    {
        $this->dispatch('init-calendar', [
            'schedule' => $this->scheduleService->formatForCalendar($this->schedule),
        ]);

        return view('livewire.schedule.calendar');
    }
}
