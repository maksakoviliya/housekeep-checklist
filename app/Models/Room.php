<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Room extends Model
{
	/** @use HasFactory<RoomFactory> */
	use HasFactory;

	protected $fillable = [
		'property_id',
		'name',
		'is_default',
	];
}
