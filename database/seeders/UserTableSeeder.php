<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    
    public function run(): void
    {
        // Seed an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

         // Seed an retular user
         User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'role' => 'user',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);
    }

    
}
