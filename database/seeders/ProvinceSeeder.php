<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // $path = storage_path('app/json/provinsi_pddikti.json');
    $path = public_path('json/provinsi_pddikti.json');
    $provinsi_dikti = json_decode(file_get_contents($path), true);
    $provinsi_dikti = $provinsi_dikti[2]['data'];
    // dd($provinsi_dikti);
    
    $i = 0;
    foreach ($provinsi_dikti as $provinsi) {
      Province::firstOrCreate([
        'code' => $provinsi['id_wil']
      ], [
        'name' => $provinsi['nm_wil']
      ]);
      $i++;
    }

    echo var_dump($i);
  }
}
