<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Major;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'name' => 'Test Alumni',
            'uname' => '123456',
            'email' => 'alumni@example.com',
            'type' => 'Alumni',
        ]);
        $major = Major::firstOrCreate([
            'code' => '1234',
            'name' => 'Informatika',
            'level' => 'S1'
        ]);
        $batch = Batch::firstOrCreate(['year' => 2018]);
        Alumni::create([
            'user_id' => $user->id,
            'fullname' => $user->name,
            'nim' => $user->uname,
            'major_id' => $major->id,
            'batch_id' => $batch->id,
            'graduate_year' => 2023,
        ]);
    }
}
