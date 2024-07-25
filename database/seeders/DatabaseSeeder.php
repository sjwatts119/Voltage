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

        User::factory()
            ->hasProfile(1)
            ->hasSettings(1)
            ->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        User::factory()
            ->hasProfile(1)
            ->hasSettings(1)
            ->create([
            'name' => 'Sam',
            'username' => 'sam',
            'email' => 'sam@example.com',
        ]);

        User::factory()
            ->hasProfile(1)
            ->hasSettings(1)
            ->create([
            'name' => 'Other 1',
            'username' => 'other1',
            'email' => '1@example.com',
        ]);

        User::factory()
            ->hasProfile(1)
            ->hasSettings(1)
            ->create([
            'name' => 'Other 2',
            'username' => 'other2',
            'email' => '2@example.com',
        ]);

        //create 50 users with profiles and settings
        User::factory(50)
            ->hasProfile(1)
            ->hasSettings(1)
            ->create();
    }
}
