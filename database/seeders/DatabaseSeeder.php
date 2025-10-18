<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
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
}
