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

        \App\Models\User::updateOrCreate(
    ['email' => 'admin@parudeesa.com'], // This is the unique field it checks first
    [
        'name' => 'Amina',
        'password' => bcrypt('password123'),
        'is_super_admin' => true
    ]
);

        $this->call([
            AmenitySeeder::class,
        ]);
    }
}
