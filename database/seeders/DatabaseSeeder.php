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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Sam',
            'email' => 'sam@example.com',
        ]);

        User::factory()->create([
            'name' => 'Other 1',
            'email' => '1@example.com',
        ]);

        User::factory()->create([
            'name' => 'Other 2',
            'email' => '2@example.com',
        ]);
    }
}
