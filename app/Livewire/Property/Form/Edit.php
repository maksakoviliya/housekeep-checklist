<?php

namespace App\Livewire\Property\Form;

use App\Models\Property;
use App\Models\User;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public Property $property;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|numeric|between:-90,90', attribute: 'latitude')]
    public ?string $lat = null;

    #[Validate('required|numeric|between:-180,180', attribute: 'longitude')]
    public ?string $lng = null;

    #[Validate('required|string|max:1000')]
    public string $address = '';

    #[Validate('required|exists:users,id')]
    public ?int $userId = null;

    public Collection $users;

    private ?PropertyService $propertyService;

    public function __construct()
    {
        $this->propertyService = new PropertyService;
        /** @var User $user */
        $user = auth()->user();
        if ($user->can('assignProperty', Property::class)) {
            $this->userId = null;
            $this->users = User::query()->users()->get();
        } else {
            $this->userId = $user->id;
        }
    }

    public function mount(Property $property): void
    {
        if (Gate::denies('update', $property)) {
            abort(403);
        }

        $this->property = $property;
        $this->name = $property->name;
        $this->lat = $property->lat;
        $this->lng = $property->lng;
        $this->address = $property->address;
        $this->userId = $property->user_id;
    }

    public function submit(): void
    {
        $this->validate();

        $this->propertyService->updateProperty($this->property, [
            'name' => $this->name,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'address' => $this->address,
            'user_id' => $this->userId,
        ]);

        $this->dispatch('property-updated');
    }

    public function render(): Factory|View
    {
        return view('livewire.property.form.edit');
    }
}
