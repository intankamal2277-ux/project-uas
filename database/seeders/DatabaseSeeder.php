<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin BeritaKini',
            'email' => 'admin@beritakini.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'favorite_categories' => ['Technology', 'Sports', 'Health', 'Business', 'Science', 'Entertainment']
        ]);
    }
}
