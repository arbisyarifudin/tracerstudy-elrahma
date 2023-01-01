<?php

namespace Database\Seeders;

use App\Models\Inbox;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inbox::firstOrCreate([
            'subject' => 'Butuh informasi terkait loker terbaru untuk jurusan Informatika',
            'category' => 'Informasi',
            'fullname' => 'Budiman',
            'nim' => '1234444',
            'email' => 'budi@gmail.com',
            'message' => 'Selamat pagi! Saya Budi alumni ELRAHMA 2010. Saya membutuhkan lowongan kerja terbaru. Jika ada mohon infonya di 08123121111, atau ditunggu pembaruan terbarunya di menu Informasi. Terima kasih.'
        ]);
    }
}
