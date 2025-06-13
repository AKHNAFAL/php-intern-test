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
