<?php

declare(strict_types=1);

namespace App\Livewire\Property\Form;

use App\Models\Property;
use App\Models\User;
use App\Services\ImageService;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Create extends Component
{
    use WithFileUploads;
    
    #[Validate('required|string|max:255')]
    public string $name = '';
	
    #[Validate('required|numeric|between:-90,90', attribute: 'latitude')]
    public string $lat = '';
	
    #[Validate('required|numeric|between:-180,180', attribute: 'longitude')]
    public string $lng = '';
    
    #[Validate('required|string|max:1000')]
    public string $address = '';

    #[Validate('image|max:1024')]
    public $photo;

    #[Validate('required|exists:users,id', attribute: 'owner')]
    public ?int $userId = null;
    
    public Collection $users;

    private PropertyService $propertyService;
    
    public function __construct()
    {
        $this->propertyService = new PropertyService();
        /** @var User $user */
        $user = auth()->user();
        if ($user->can('assignProperty', Property::class)) {
            $this->userId = null;
            $this->users = User::query()->users()->get();
        } else {
            $this->userId = $user->id;
        }
    }

    public function mount(): void
    {
        $this->dispatch('property-form-mounted');
    }

    public function createProperty(): null
    {
        $this->validate();

        $property = $this->propertyService->createProperty([
            'name' => $this->name,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'address' => $this->address,
            'user_id' => $this->userId,
            'photo' => $this->photo,
        ]);

        return $this->redirect(route('properties.edit', [
            'property' => $property->id,
        ]));
    }

    public function render(): Factory|View
    {
        return view('livewire.property.form.create');
    }
}
