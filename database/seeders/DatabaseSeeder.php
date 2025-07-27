<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Supplier;
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
        // Supplier::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'alpa@mail.com',
            'password' => bcrypt('123'),
            'role' => 'super_admin',
        ]);
    }
}
