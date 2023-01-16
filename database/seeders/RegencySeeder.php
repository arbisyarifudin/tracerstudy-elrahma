<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Regency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $path = storage_path('app/json/kabkota_pddikti.json');
        $path = public_path('json/kabkota_pddikti.json');
        $kabkota_dikti = json_decode(file_get_contents($path), true);
        $kabkota_dikti = $kabkota_dikti[2]['data'];
        // dd($kabkota_dikti);

        $i = 0;
        foreach ($kabkota_dikti as $kabkota) {
            $province = Province::where('code', $kabkota['id_induk_wilayah'])->first();
            if ($province) {
                Regency::firstOrCreate([
                    'code' => $kabkota['id_wil'],
                ], [
                    'province_id' => $province->id,
                    'name' => $kabkota['nm_wil']
                ]);
                $i++;
            }
        }

        echo var_dump($i);
    }
}
