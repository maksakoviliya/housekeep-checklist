<?php

namespace App\Livewire\Schedule\Form;

use App\Enums\UserRole;
use App\Models\Schedule;
use App\Models\User;
use App\Services\ScheduleService;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('required|date_format:Y-m-d')]
    public string $date = '';

    #[Validate('required|exists:users,id')]
    public ?int $housekeeperId = null;

    public array $timeAvailable = [
        '08:00',
        '09:00',
        '10:00',
        '11:00',
        '12:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
        '17:00',
        '18:00',
        '19:00',
        '20:00',
        '21:00',
        '22:00',
    ];

    #[Validate('required|date_format:H:i')]
    public string $time;

    public Schedule $schedule;

    private ScheduleService $scheduleService;

    public function __construct()
    {
        $this->scheduleService = new ScheduleService;
    }

    public function setEvent($data): void
    {
        $this->schedule = Schedule::query()->find(Arr::get($data, 'event.id'));
        $date = Carbon::parse(Arr::get($data, 'event.start'));
        $this->date = $date->format('Y-m-d');
        $this->time = $date->format('H:i');
        $this->housekeeperId = Arr::get($data, 'event.extendedProps.user_id');
    }

    #[Computed]
    public function housekeepers(): Collection
    {
        return User::query()
            ->where('role', UserRole::HOUSEKEEPER)
            ->get();
    }

    public function submit(): void
    {
        $this->validate();

        $this->schedule->update([
            'user_id' => $this->housekeeperId,
            'scheduled_at' => new Carbon("$this->date $this->time"),
        ]);

        Flux::modal('schedule-edit')->close();
        $this->dispatch('schedule-edited');
    }

    public function render(): Factory|View
    {
        return view('livewire.schedule.form.edit');
    }
}
