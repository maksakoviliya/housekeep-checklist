<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->truncate();
        
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@mail.ru',
            'role' => UserRole::USER->value,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'role' => UserRole::ADMIN->value,
        ]);

        User::factory()->create([
            'name' => 'Housekeeper',
            'email' => 'housekeeper@mail.ru',
            'role' => UserRole::HOUSEKEEPER->value,
        ]);
    }

    public function down(): void
    {
        //
    }
};
