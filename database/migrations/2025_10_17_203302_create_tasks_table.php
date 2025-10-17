<?php

declare(strict_types=1);

use App\Models\Property;
use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Property::class)->constrained()->onDelete('cascade');
			$table->foreignIdFor(Room::class)->constrained()->onDelete('cascade');
			$table->text('task');
			$table->boolean('is_default')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
