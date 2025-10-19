<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property int $property_id
 * @property string $name
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection $tasks
 */
final class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'is_default',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
