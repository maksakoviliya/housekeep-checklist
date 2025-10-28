<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ChecklistFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Checklist extends Model
{
    /** @use HasFactory<ChecklistFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'property_id',
        'room_id',
        'user_id',
        'started_at',
        'finished_at',
        'is_checked',
        'notes',
        'image',
    ];
}
