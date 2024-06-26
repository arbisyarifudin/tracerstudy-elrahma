<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(BatchSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(AlumniSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(RegencySeeder::class);
        $this->call(FormAndQuestionSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ContentSeeder::class);
        $this->call(ContentHasCategorySeeder::class);
    }
}
