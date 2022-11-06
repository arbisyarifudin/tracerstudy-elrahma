<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Mr. Admin',
            'email' => 'admin@example.com',
            'type' => 'Administrator',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test Alumni',
            'email' => 'alumni@example.com',
            'type' => 'Alumnus',
        ]);
    }
}
