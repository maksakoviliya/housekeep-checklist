<?php

namespace App\Livewire\Property\Form;

use App\Models\Property;
use App\Models\User;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public Property $property;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|numeric|min:1|max:100')]
    public ?int $beds = null;

    #[Validate('required|numeric|min:1|max:100')]
    public ?int $baths = null;

    #[Validate('required|exists:users,id')]
    public ?int $userId = null;

    private ?PropertyService $propertyService;

    public function __construct()
    {
        $this->propertyService = new PropertyService;
        /** @var User $user */
        $user = auth()->user();
        if ($user->can('assignProperty')) {
            $this->userId = null;
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
        $this->beds = $property->beds;
        $this->baths = $property->baths;
        $this->userId = $property->user_id;
    }

    public function submit(): void
    {
        $this->validate();

        $this->propertyService->updateProperty($this->property, [
            'name' => $this->name,
            'beds' => $this->beds,
            'baths' => $this->baths,
            'user_id' => $this->userId,
        ]);

        $this->dispatch('property-updated');
    }

    public function render(): Factory|View
    {
        return view('livewire.property.form.edit');
    }
}
