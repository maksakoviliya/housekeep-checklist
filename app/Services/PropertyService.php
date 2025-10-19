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
                'beds' => Arr::get($data, 'beds'),
                'baths' => Arr::get($data, 'baths'),
                'user_id' => Arr::get($data, 'user_id'),
            ]);
    }

    public function updateProperty(Property $property, array $data): Property
    {
        $data = [
            'name' => Arr::get($data, 'name'),
            'beds' => Arr::get($data, 'beds'),
            'baths' => Arr::get($data, 'baths'),
        ];

        $userId = Arr::get($data, 'userId');
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
