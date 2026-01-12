
# Aplikasi Laporan Kerusakan Forklift v2
##### _Aplikasi untuk melakukan serah terima kerusakan alat ke teknisi_

[![ForTheBadge uses-html](http://ForTheBadge.com/images/badges/uses-html.svg)](http://ForTheBadge.com)[![ForTheBadge uses-css](http://ForTheBadge.com/images/badges/uses-css.svg)](http://ForTheBadge.com)[![ForTheBadge uses-js](http://ForTheBadge.com/images/badges/uses-js.svg)](http://ForTheBadge.com)

[![ForTheBadge built-by-developers](http://ForTheBadge.com/images/badges/built-by-developers.svg)](https://GitHub.com/Naereen/)[![ForTheBadge built-with-love](http://ForTheBadge.com/images/badges/built-with-love.svg)](https://GitHub.com/Naereen/)



## Features Aplikasi Sparepart

- Login Role User (Admin, Operator, Koordinator, Teknisi, sparepart)
- Laporan kerusakan
- Master User
- Export laporan ke PDF
  
## Tech

Aplikasi ini dibangun menggunakan Laravel 9 +  Laravel Auth UI Bootstrap + AdminLTE


## Requirment :

- XAMPP 8.1.25 or later
- Composer 2.8.8 or later
- Node.Js
- PHP 8.1.25 or later
- Visual Studio Code
- Laravel 9


#### Install :

```sh
git clone https://github.com/Hery05/Perbaikan-Forklift-v2.git
```

#### Jalankan

```sh
composer install
```
```sh
cp .env.example .env
```
```sh
php artisan key:generate
```
```sh
php artisan migrate
```
**Note : Buat Seeder**

```sh
php artisan make:seeder UsersSeeder
```

**Isi Seeder**

```sh
use App\Models\User;
public function run(){
    User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('secret'),'role'=>'admin']);
}
```

**Jalankan Seeder**

```sh
php artisan db:seed --class=UsersSeeder
```

## Preview Demo Aplikasi

1. Halaman Login

<img width="1917" height="790" alt="Image" src="https://github.com/user-attachments/assets/00f519ca-f101-4f9a-9b76-d018b24c0b20" />

2. Dashboard Admin

<img width="1911" height="807" alt="Image" src="https://github.com/user-attachments/assets/08f77bf4-e8bf-463a-9602-e72c0c64dc06" />

3. Dashboard Sparepart
   
<img width="1917" height="779" alt="Image" src="https://github.com/user-attachments/assets/e3c2620c-c93f-4911-924a-1632becb3ca4" />

4. Form Sparepart Request

<img width="1919" height="821" alt="Image" src="https://github.com/user-attachments/assets/25cd4a67-7106-4f74-bfd9-5050a2106189" />

6. Dan Lain-lain  

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">

<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.
