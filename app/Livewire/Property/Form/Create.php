<?php

declare(strict_types=1);

namespace App\Livewire\Property\Form;

use App\Enums\UserRole;
use App\Models\DefaultRoom;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        $this->propertyService = new PropertyService;
        /** @var User $user */
        $user = auth()->user();
        if ($user->can('assignProperty', Property::class)) {
            $this->userId = Auth::id();
            $this->users = User::query()->whereIn('role', [
				UserRole::USER->value,
	            UserRole::ADMIN->value
            ])->get();
        } else {
            $this->userId = $user->id;
        }
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
