<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
        return view('properties.index', [
            'properties' => $this->propertyService->getPropertiesForUser($request->user()),
        ]);
    }
}
