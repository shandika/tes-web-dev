Langkah Menjalankan Project:
1. ubah file .env.example menjadi .env (kemudian atur konfigurasi database sesuai dengan perangkat Anda)
2. composer update
3. php artisan migrate
4. php artisan db:seed --class=CreateProgramsSeeder
5. php artisan key:generate
6. php artisan serve
