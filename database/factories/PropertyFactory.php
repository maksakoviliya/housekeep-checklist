<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
final class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->streetName(),
            'beds' => fake()->numberBetween(1, 5),
            'baths' => fake()->numberBetween(1, 5),
        ];
    }
}
