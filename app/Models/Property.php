<?php

declare(strict_types=1);

namespace App\Models;

use App\Policies\PropertyPolicy;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Property
 *
 * @property int $id
 * @property string $name
 * @property int $beds
 * @property int $baths
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $owner
 */
#[UsePolicy(PropertyPolicy::class)]
final class Property extends Model
{
    /** @use HasFactory<PropertyFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'beds',
        'baths',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class, 'property_id');
    }
}
