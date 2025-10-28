<?php

declare(strict_types=1);

namespace App\Livewire\Schedule\Form;

use App\Enums\UserRole;
use App\Models\Property;
use App\Models\User;
use App\Services\ScheduleService;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Create extends Component
{
    #[Validate('required|date_format:Y-m-d')]
    public string $date = '';

    public Property $property;

    #[Validate('required|exists:users,id')]
    public ?int $housekeeperId = null;

    public array $timeAvailable = [
        '08:00', '09:00', '10:00', '11:00', '12:00',
        '13:00', '14:00', '15:00', '16:00', '17:00',
        '18:00', '19:00', '20:00', '21:00', '22:00',
    ];

    #[Validate('required|date_format:H:i')]
    public string $time;

    private ScheduleService $scheduleService;

    public function __construct()
    {
        $this->scheduleService = new ScheduleService;
    }

    public function mount(Property $property): void
    {
        $this->date = date('Y-m-d');
        $this->time = '12:00';
        $this->property = $property;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
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

        $this->scheduleService->create(
            $this->property,
            User::query()->find($this->housekeeperId),
            new Carbon("$this->date $this->time")
        );

        Flux::modal('schedule-cleaning')->close();
        $this->dispatch('schedule-created');
    }

    public function render(): Factory|View
    {
        return view('livewire.schedule.form.create');
    }
}
