<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\DefaultRoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class DefaultRoom extends Model
{
    /** @use HasFactory<DefaultRoomFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
