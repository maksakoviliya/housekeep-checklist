<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Property;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

final readonly class PropertyService
{
    private ImageService $imageService;
    
    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    public function getPropertiesForUser(User $user): ?LengthAwarePaginator
    {
        if ($user->role === UserRole::ADMIN) {
            return Property::query()->paginate();
        }

        if ($user->role === UserRole::USER) {
            return $user->properties()->paginate();
        }

        return null;
    }

    public function createProperty(array $data): Property
    {
        return Property::query()
            ->create([
                'name' => Arr::get($data, 'name'),
                'lat' => Arr::get($data, 'lat'),
                'lng' => Arr::get($data, 'lng'),
                'address' => Arr::get($data, 'address'),
                'user_id' => Arr::get($data, 'user_id'),
                'photo' => $this->imageService->storeImage(Arr::get($data, 'photo')),
            ]);
    }

    public function updateProperty(Property $property, array $params): Property
    {
        $data = [
            'name' => Arr::get($params, 'name'),
            'lat' => Arr::get($params, 'lat'),
            'lng' => Arr::get($params, 'lng'),
            'address' => Arr::get($params, 'address'),
        ];
        if (!is_string(Arr::get($params, 'photo'))) {
            $data['photo'] = $this->imageService->storeImage(Arr::get($params, 'photo'));
        }

        $userId = Arr::get($params, 'userId');
        if ($userId && $property->user_id !== $userId) {
            $data['user_id'] = $userId;
        }
        $property->update($data);

        return $property->refresh();
    }

    public function getRoomsForProperty(Property $property): LengthAwarePaginator
    {
        return $property->rooms()->paginate();
    }

    public function getScheduleForProperty(Property $property): LengthAwarePaginator
    {
        return $property->schedule()->paginate();
    }

    public function createRoom(array $data, Property $property)
    {
        return $property->rooms()->create([
            'name' => Arr::get($data, 'name'),
        ]);
    }
}
