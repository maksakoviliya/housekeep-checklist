<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class PropertyController extends Controller
{
    public function __construct(
        protected PropertyService $propertyService,
    ) {}

    public function index(Request $request): Factory|View
    {
        if ($request->user()->cannot('create', Property::class)) {
            return view('properties.housekeeper');
        }

        return view('properties.index', [
            'properties' => $this->propertyService->getPropertiesForUser($request->user()),
        ]);
    }

    public function rooms(Property $property): Factory|View
    {
        return view('properties.rooms.index', [
            'property' => $property,
            'rooms' => $this->propertyService->getRoomsForProperty($property),
        ]);
    }

    public function schedule(Property $property): Factory|View
    {
        return view('properties.schedule.index', [
            'property' => $property,
            'schedule' => $this->propertyService->getScheduleForProperty($property),
        ]);
    }
}
