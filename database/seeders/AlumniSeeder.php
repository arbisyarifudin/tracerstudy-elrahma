<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Major;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $major = Major::firstOrCreate([
            'code' => '1234',
            'name' => 'Informatika',
            'level' => 'S1'
        ]);
        $batch = Batch::firstOrCreate(['year' => 2018]);

        $userAlumni = User::firstOrCreate([
            'name' => 'Test Alumni',
            'uname' => '123456',
            'email' => 'alumni@example.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'type' => 'Alumni',
            'password' => Hash::make('123456')
        ]);
        Alumni::firstOrCreate([
            'user_id' => $userAlumni->id,
            'uname' => $userAlumni->uname,
        ], [
            'fullname' => $userAlumni->name,
            'email' => $userAlumni->email,
            'gender' => 'L',
            'nim' => $userAlumni->uname,
            'major_id' => $major->id,
            'batch_id' => $batch->id,
            'graduate_year' => 2023,
        ]);

        $faker = Factory::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $uname = '12345' . str_pad($i, 3, "0", STR_PAD_LEFT);
            $user = User::firstOrCreate([
                'name' => $faker->name($gender),
                // 'uname' => '12345' . $i,
                'uname' => $uname,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'email' => $faker->safeEmail,
                'type' => 'Alumni',
                'password' => Hash::make($uname),
                'status' => 1 // active or verified by admin
            ]);
            $genderIndo = $gender === 'male' ? 'L' : 'P';
            // $phoneNumber = $faker->phoneNumber;
            Alumni::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'fullname' => $user->name,
                'email' => $user->email,
                // 'phone_number' => $phoneNumber,
                // 'wa_number' => $phoneNumber,
                'gender' => $genderIndo,
                'nim' => $user->uname,
                'major_id' => $major->id,
                'batch_id' => $batch->id,
                'graduate_year' => 2023,
            ]);
        }
    }
}
