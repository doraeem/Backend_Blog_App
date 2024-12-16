<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, run the AdminUserSeeder to ensure the admin user is created
        $this->call([
            AdminUserSeeder::class, // Add AdminUserSeeder to create the admin user
        ]);

        // If you want to create more test users with a factory
        // Using the factory to create additional users
        User::factory(10)->create(); // Creates 10 random users
        
        // You can also manually create a test user here
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Remember to hash the password
        ]);
    }
}
