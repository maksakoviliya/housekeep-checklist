<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Property;
use App\Models\Room;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'room_id' => Room::factory(),
            'text' => fake()->text(),
            'is_default' => fake()->boolean(70),
        ];
    }
}
