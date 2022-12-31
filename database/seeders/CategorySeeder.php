<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categories::firstOrCreate([
            'title' => 'Pengumuman',
            'description' => null,
        ]);
        Categories::firstOrCreate([
            'title' => 'Lowongan Kerja',
            'description' => null,
        ]);
    }
}
