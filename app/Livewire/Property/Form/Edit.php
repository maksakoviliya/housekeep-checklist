<?php

namespace App\Livewire\Property\Form;

use App\Models\Property;
use App\Models\User;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

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

    #[Validate('required')]
    public $photo;

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
        $this->photo = $property->photo;
        $this->userId = $property->user_id;
    }

	public function updatedAddress($value): void
	{
		if (strlen($value) > 5) { // Минимальная длина адреса
			$this->getCoordinatesFromAddress($value);
		}
	}

	private function getCoordinatesFromAddress($address): void
	{
		try {
			// Пример с использованием Nominatim (OpenStreetMap)
			$response = Http::timeout(10)
				->withHeaders([
					'User-Agent' => config('app.name') . ' Contact: your@email.com',
					'Referer' => config('app.url')
				])
				->get('https://nominatim.openstreetmap.org/search', [
				'q' => $address,
				'format' => 'json',
				'limit' => 1,
				'addressdetails' => 1
			]);

			if ($response->successful()) {
				$data = $response->json();
				if (!empty($data)) {
					$this->lat = $data[0]['lat'];
					$this->lng = $data[0]['lon'];

					// Диспатчим событие для обновления карты (если нужно)
					$this->dispatch('coordinatesUpdated', [
						'lat' => $this->lat,
						'lng' => $this->lng
					]);
				}
			}
		} catch (\Exception $e) {
			Log::error('Geocoding error: ' . $e->getMessage());
		}
	}

    public function submit(): void
    {
        $this->validate();

        $this->propertyService->updateProperty($this->property, [
            'name' => $this->name,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'address' => $this->address,
            'photo' => $this->photo,
            'user_id' => $this->userId,
        ]);

        $this->dispatch('property-updated');
    }

    public function render(): Factory|View
    {
        return view('livewire.property.form.edit');
    }
}
