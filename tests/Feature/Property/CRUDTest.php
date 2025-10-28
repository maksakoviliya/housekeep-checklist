<?php

declare(strict_types=1);

namespace Tests\Feature\Property;

use App\Livewire\Property\Form\Create as CreatePropertyForm;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CRUDTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	public function test_can_create_property(): void
	{
		$data = [
			'name' => $this->faker->sentence,
			'lat' => $this->faker->latitude,
			'lng' => $this->faker->longitude,
		];

		$this->actingAs(User::factory()->user()->create());

		$response = Livewire::test(CreatePropertyForm::class)
			->set('name', $data['name'])
			->set('lat', $data['lat'])
			->set('lng', $data['lng'])
			->call('createProperty');

		$this->assertDatabaseHas('properties', [
			'name' => $data['name'],
			'lat' => $data['lat'],
			'lng' => $data['lng'],
		]);

		$property = Property::query()->where('name', $data['name'])->first();

		$response->assertHasNoErrors()->assertRedirect(
			route(
				'properties.edit', [
				'property' => $property->id,
		]));
	}
}
