<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Property;
use App\Models\User;

final class PropertyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function assignProperty(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function view(User $user, Property $property): bool
    {
        if ($this->viewAny($user)) {
            return true;
        }

        return $user->properties()->where('properties.id', $property->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::USER;
    }

    public function update(User $user, Property $property): bool
    {
        if ($this->viewAny($user)) {
            return true;
        }

        return $user->ownedProperties()->where('properties.id', $property->id)->exists();
    }

    public function delete(User $user, Property $property): bool
    {
        return $this->update($user, $property);
    }
}
