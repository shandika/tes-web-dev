Langkah Menjalankan Project:
1. ubah file .env.example menjadi .env (kemudian atur database sesuai dengan perangkat Anda)
2. composer install
3. composer update
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed --class=CreateProgramsSeeder
7. php artisan serve
