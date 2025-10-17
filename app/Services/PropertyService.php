<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final readonly class PropertyService
{
    public function getPropertiesForUser(User $user): Collection
    {
        if ($user->role === UserRole::ADMIN) {
            return Property::query()->get();
        }

        if ($user->role === UserRole::USER) {
            return $user->ownedProperties;
        }

        return $user->housekeepingProperties;
    }
}
