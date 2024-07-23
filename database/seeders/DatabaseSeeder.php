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
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Sam',
            'username' => 'sam',
            'email' => 'sam@example.com',
        ]);

        User::factory()->create([
            'name' => 'Other 1',
            'username' => 'other1',
            'email' => '1@example.com',
        ]);

        User::factory()->create([
            'name' => 'Other 2',
            'username' => 'other2',
            'email' => '2@example.com',
        ]);
    }
}
