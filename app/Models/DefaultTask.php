<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\DefaultTaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class DefaultTask extends Model
{
    /** @use HasFactory<DefaultTaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
