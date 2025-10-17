<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;
	
	protected $fillable = [
		'property_id',
		'room_id',
		'text',
		'is_default',
	];
}
