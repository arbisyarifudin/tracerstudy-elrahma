<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => 'Mr. Admin',
            'uname' => 'admin',
            'email' => 'admin@example.com',
            'type' => 'Administrator',
            'password' => Hash::make('admin')
        ]);
        User::firstOrCreate([
            'name' => 'Test Alumni',
            'uname' => '123456',
            'email' => 'alumni@example.com',
            'type' => 'Alumni',
            'password' => Hash::make('123456')
        ]);
    }
}
