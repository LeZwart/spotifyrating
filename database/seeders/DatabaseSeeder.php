<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        // Email:       admin@admin.nl
        // Password:    password
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.nl',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Regular users
        User::factory(24)->create();
    }
}
