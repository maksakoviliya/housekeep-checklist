<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PropertyOwnership;
use App\Enums\UserRole;
use App\Models\Property;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

final readonly class PropertyService
{
    public function getPropertiesForUser(User $user): LengthAwarePaginator
    {
        if ($user->role === UserRole::ADMIN) {
            return Property::query()->paginate();
        }

        if ($user->role === UserRole::USER) {
            return $user->ownedProperties()->paginate();
        }

        return $user->housekeepingProperties()->paginate();
    }

    public function createPropertyForUser(array $data, User|int $user): Property
    {
        $user = $user instanceof User ? $user : User::query()->findOrFail($user);

        $property = Property::query()
            ->create([
                'name' => Arr::get($data, 'name'),
                'beds' => Arr::get($data, 'beds'),
                'baths' => Arr::get($data, 'baths'),
            ]);

        $user->ownedProperties()->attach($property, [
            'type' => PropertyOwnership::OWNER->value
        ]);

        return $property;
    }
}
