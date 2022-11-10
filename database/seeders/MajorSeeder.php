<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Major::insert([
      [
        'code' => '1234',
        'name' => 'Informatika',
        'level' => 'S1'
      ],
      [
        'code' => '1235',
        'name' => 'Sistem Informasi',
        'level' => 'S1'
      ]
    ]);
  }
}
