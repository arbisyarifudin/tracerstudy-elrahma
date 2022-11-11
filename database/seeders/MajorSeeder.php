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
    Major::firstOrCreate([
      'code' => '1234',
      'name' => 'Informatika',
      'level' => 'S1'
    ]);
    Major::firstOrCreate([
      'code' => '1235',
      'name' => 'Sistem Informasi',
      'level' => 'S1'
    ]);
  }
}
