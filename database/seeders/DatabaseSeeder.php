<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mr Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(12345678),
            'is_admin' => true
        ]);
        User::factory()->count(27)->create();
        Project::factory()->count(15)->create();
    }
}
