<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ScheduleStatus;
use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Schedule
 *  
 * @property int $id
 * @property int $property_id
 * @property int $user_id
 * @property Carbon $scheduled_at
 * @property ScheduleStatus $status
 * @property-read User $housekeeper
 */
final class Schedule extends Model
{
    /** @use HasFactory<ScheduleFactory> */
    use HasFactory;
    
    protected $fillable = [
        'property_id',
        'user_id',
        'scheduled_at',
        'status',
    ];
    
    protected $casts = [
        'scheduled_at' => 'datetime',
        'status' => ScheduleStatus::class,
    ];

    public function housekeeper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
