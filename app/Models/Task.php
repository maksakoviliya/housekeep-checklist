<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property string $task
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
final class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'property_id',
        'room_id',
        'task',
        'is_default',
    ];
}
