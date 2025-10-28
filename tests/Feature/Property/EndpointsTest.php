<?php

declare(strict_types=1);

namespace Tests\Feature\Property;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_properties_endpoint_is_disable_for_unauthorized(): void
    {
        $response = $this->get(route('properties.index'));
        $response->assertRedirectToRoute('login');
    }

    public function test_properties_endpoint(): void
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('properties.index'));
        $response->assertStatus(200);
    }

    public function test_create_endpoint_is_available()
    {
        $this->actingAs(User::factory()->user()->create());
        $response = $this->get(route('properties.create'));
        $response->assertStatus(200);
    }
}
