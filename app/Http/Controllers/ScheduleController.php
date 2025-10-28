<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Schedule;

final class ScheduleController extends Controller
{
    public function view(Property $property, Schedule $schedule)
    {
        return view('schedule.view', [
            'schedule' => $schedule,
        ]);
    }
}
