# Nomor 1
Ini untuk meng-run file PHP.CLI.php

Untuk mengetahui output dari file PHP-CLI.php, pastikan php terinstall. Kemudian pastikan terminal anda berada di directory ASI/php-cli. 

Kemudian, run command: 
```bash
php PHP-CLI.php
```

# Nomor 2

Installasi dan Setup Local seperti biasa, Panduan dibawah ini adalah pola panduan yang sudah saya pernah buat di project-project saya sebelumnya:

## 1. Clone Repository

```bash
git clone https://github.com/AKHNAFAL/php-intern-test.git
cd php-intern-test
```

## 2. Install Dependency Backend

```bash
composer install
```

## 3. Salin dan Konfigurasi .env

```bash
cp .env.example .env
php artisan key:generate
```

# Penjelasnan

Saya pertama membuat database di laragon mysql da nmenyesuaikannya di .env. Kemudian membuat migrate untuk create table employee dan menjalankan php artisan migrate:fresh. Kemudian membuat model yang sesuai dengan tabel. Setelah membuat CRUD controller. Bersamaan dengan dengan tambahan intergrasi:
- isi field photo_upload_path adalah URL dari hasil upload S3.
- buatkan redis dengan index emp_<nomor> yang berisi json record dari table.
