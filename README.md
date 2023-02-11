# TRACER STUDY ELRAHMA

Tracer Study ELRAHMA adalah Sistem Informasi Alumni yang digunakan oleh Perguruan Tinggi untuk pengelolaan data alumni, media pencatatan dan pelacakan lulusan kampus serta forum diskusi yang terkait dengan topik-topik tertentu yang relevan untuk alumni dan dunia setelah lulus dari kampus.

***

Aplikasi ini untuk menggunakan `RestFul` yang di kembangkan menggunakan bahasa pemrograman `PHP` dan framework `Laravel` versi 9, serta didukung oleh framework frontend `VueJS`.

## 1. Kebutuhan untuk development
- PHP versi terbaru https://www.php.net/downloads.php beserta kelengkapan paketnya  bisa dicek di https://laravel.com/docs/9.x
- PostgreSQL versi terbaru https://www.postgresql.org/ atau MySQL versi terbaru
- Git https://git-scm.com
- Composer https://getcomposer.org
- [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer) untuk standar coding (Optional)

## 2. Cara Menjalankan Aplikasi
- Pastikan di komputer sudah terinstal untuk kebutuhan development (Point no.1)
- Clone Repo ini
- Gunakan terminal atau command line
- Copy file **.env.example** menjadi **.env**
  
        cp .env.example .env

- Atur koneksi database
   
        DB_HOST=127.0.0.1
        DB_PORT=5432
        DB_DATABASE=database_name
        DB_USERNAME=database_user
        DB_PASSWORD=database_password

- Eksekusi `composer install`
- Eksekusi `npm install`
<!-- - Eksekusi `php artisan jwt:secret` -->
- Eksekusi `php artisan migrate`
- Eksekusi `php artisan db:seed`

## 3. Cara Menjalankan Projek

Untuk menjalankan Laravel API, jalankan perintah

    php artisan serve
  
atau bisa menggunakan 

    ./serve.sh 8000

Untuk menjalankan VueJS frontend, jalankan perintah

    npm run dev
  
## Struktur Projek

Untuk mengurangi jumlah baris pada `controller`, projek ini memisahkan proses bisnis dengan controller pada folder `app/Repositories`.

    - app
      - Http
        - Controllers
          - YourController.php
      - Repositories
        - YourController
          - DestroyHandling.php
          - ListHandling.php
          - ShowHandling.php
          - StoreHandling.php
          - UpdateHandling.php

**Untuk desain database aplikasi ini ada [di sini](#)**
  
Untuk routing menggunakan 2 file:
- `web.php` untuk route yang diakses oleh pengguna
- `api.php` untuk route yang dipakai untuk melakukan operasi melalui `Restful API`

## Coding Style
- Menggunakan `camelCase` untuk nama variable dan fungsi
- Penggunaan plural untuk penamaan variable dan fungsi yang berupa array / banyak data, dan singular untuk data tunggal. 
  Misal: `$users = User::all();` bentuk plural / banyak dan `$user = User::find($id);` untuk bentuk singular / tunggal
- Menggunakan petik satu `'...'` untuk string dan petik dua `"..."` hanya untuk alternatif
- Nilai boolean adalah `true` dan `false` dengan huruf kecil
- Penamaan route menggunakan `lowercase` dan untuk yang lebih dari 1 kata dihubungkan dengan tanda `-`
- Struktur folder Repositories menyesuaikan dengan contoh **Struktur Project** di atas
- Untuk nama fungsi di controller dan struktur repositories tambahan yang tidak ada dalam standar template di atas, diwajibkan menggunakan nama yang jelas, bahasa inggris, dan menggunakan `camelCase`
- Khusus data berbentuk list menggunakan **Laravel Query Builder** untuk optimasi pengambilan data
- Selain data berbentuk list menggunakan **Laravel Eloquent ORM**

## How to push update
Untuk keperluan development maka branch yang dikerjakan masing-masing developer akan dibuat terpisah sesuai nama masing-masing developer.  
Untuk langkah-langkah penggunaan repository ini sebagai berikut :
1. Clone repo ini
 
        git clone repo-url
2. Chekout ke branch masing-masing

        git checkout -b your-branch
3. Sebelum melanjutkan coding mohon update source code dari branch `main` dulu

        git checkout your-branch
        git pull origin main
4. Setiap mau mengupdate pada repository lakukan langkah berikut

        git add .
        git pull origin your-branch
        git commit -m "commit comment"
        git push origin your-branch
5. Untuk merge / menggabungkan perubahan ke main gunakan fitur **Merge Request** pada GitLab guna pengecekan apakah terjadi konflik atau tidak. 
6. Pastikan jika semua perubahan sudah dipush jangan lupa untuk kembali update dari branch `main`

        git checkout your-branch
        git pull origin main

## Tim Developer
1. [Arbi Syarifudin](mailto:arbisyarifudin@gmail.com)
