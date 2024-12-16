<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        
        $adminExists = User::where('email', 'admin@gmail.com')->exists();

        if (!$adminExists) {
            // fixed admin user
            User::create([
                'name' => 'admin', 
                'email' => 'admin@gmail.com', 
                'password' => Hash::make('admin123'), 
            ]);
            echo "Admin user created successfully.\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}
