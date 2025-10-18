<?php

declare(strict_types=1);

namespace App\Livewire\Property\Form;

use App\Models\User;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Create extends Component
{
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

    public function submit(): null
    {
        $this->validate();

        $property = $this->propertyService->createProperty([
            'name' => $this->name,
            'beds' => $this->beds,
            'baths' => $this->baths,
            'user_id' => $this->userId,
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
