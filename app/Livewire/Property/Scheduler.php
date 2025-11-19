<?php

declare(strict_types=1);

namespace App\Livewire\Property;

use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Scheduler extends Component
{
    public Property $property;
    
    public $schedule;

    public function mount(Property $property): void
    {
        $this->property = $property;
        $propertyService = new PropertyService();
        $this->schedule = $propertyService->getScheduleForProperty($this->property);
    }
    
    public function render()
    {
        return view('livewire.property.scheduler');
    }
}
