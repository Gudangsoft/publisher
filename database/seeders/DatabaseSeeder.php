<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Publisher',
            'email' => 'admin@publisher.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Create Regular Users for testing
        User::create([
            'name' => 'User Demo',
            'email' => 'user@publisher.com',
            'password' => Hash::make('user123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Siti Rahmawati',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Seed Categories first
        $this->call(CategorySeeder::class);
        
        // Seed Authors
        $this->call(AuthorSeeder::class);
        
        // Seed Books
        $this->call(BookSeeder::class);
        
        // Seed News
        $this->call(NewsSeeder::class);
        
        // Seed Reviews
        $this->call(ReviewSeeder::class);
    }
}
