<?php

declare(strict_types=1);

namespace App\Livewire\Property\Room\Form;

use App\Models\Property;
use App\Models\User;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
final class Create extends Component
{
    public Property $property;

    #[Validate('required|string|max:255')]
    public string $name = '';

    private PropertyService $propertyService;

    public function __construct()
    {
        $this->propertyService = new PropertyService();
    }

    public function mount(Property $property): void
    {
        $this->property = $property;
    }

    public function submit(): null
    {
        $this->validate();

        $room = $this->propertyService->createRoom([
            'name' => $this->name
        ], $this->property);

        return $this->redirect(route('properties.rooms.edit', [
            'property' => $this->property->id,
            'room' => $room->id,
        ]), true);
    }

    public function render(): Factory|View
    {
        return view('livewire.property.room.form.create');
    }
}
