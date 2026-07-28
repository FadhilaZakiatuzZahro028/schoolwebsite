# Website Resmi SMA PGRI 1 Tulungagung

Website resmi SMA PGRI 1 Tulungagung dibangun menggunakan Laravel dan Filament. Aplikasi menyediakan panel admin untuk mengelola konten sekolah serta menjadi fondasi bagi frontend publik sekolah.

## Teknologi

* PHP 8.3 atau lebih baru
* Laravel 13
* Filament 5
* Livewire 4
* MySQL
* Bootstrap 5
* Tailwind CSS 4
* Vite 8
* Intervention Image
* PHPUnit 12

## Modul Backend

Panel admin saat ini mencakup pengelolaan:

* profil sekolah;
* pengaturan situs;
* hero banner;
* berita dan kategori berita;
* prestasi;
* ekstrakurikuler;
* fasilitas;
* galeri;
* kurikulum;
* guru dan karyawan;
* SPMB;
* Alumni Pilihan;
* pengetahuan chatbot;
* pesan kontak;
* akun admin;
* statistik dashboard.

## Persyaratan

Pastikan perangkat telah memiliki:

* PHP 8.3 atau lebih baru;
* Composer;
* Node.js dan npm;
* MySQL;
* ekstensi PHP yang dibutuhkan Laravel;
* web server lokal seperti Laragon atau Laravel development server.

## Instalasi Lokal

Clone repository dan masuk ke folder project:

```bash
git clone https://github.com/FadhilaZakiatuzZahro028/schoolwebsite.git
cd schoolwebsite
```

Install dependency PHP:

```bash
composer install
```

Salin file environment dan buat application key:

### Windows PowerShell

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

### Linux atau macOS

```bash
cp .env.example .env
php artisan key:generate
```

Buat database MySQL, kemudian sesuaikan konfigurasi berikut di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smapgri1ta
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration:

```bash
php artisan migrate
```

Buat symbolic link untuk file publik:

```bash
php artisan storage:link
```

Install dependency frontend dan build asset:

```bash
npm install
npm run build
```

Bersihkan cache konfigurasi:

```bash
php artisan optimize:clear
```

## Membuat Super Admin Pertama

Jalankan Laravel Tinker:

```bash
php artisan tinker
```

Kemudian buat akun super admin:

```php
App\Models\User::create([
    'name' => 'Super Admin',
    'email' => 'admin@example.com',
    'password' => 'ganti-dengan-password-kuat',
    'role' => 'super_admin',
]);
```

Ganti email dan password contoh sebelum digunakan. Password akan di-hash otomatis oleh model.

## Menjalankan Project

Untuk menjalankan server, queue worker, log viewer, dan Vite secara bersamaan:

```bash
composer dev
```

Pada Laragon, project juga dapat diakses melalui virtual host yang telah dikonfigurasi, misalnya:

```text
http://smapgri1ta.test
```

Panel admin tersedia pada:

```text
http://smapgri1ta.test/admin
```

## Menjalankan Pengujian

Jalankan seluruh test suite melalui Composer:

```bash
composer test
```

Atau langsung melalui Artisan:

```bash
php artisan test --process-isolation
```

Pengujian memakai SQLite in-memory, cache array, queue synchronous, session array, dan mail array melalui `phpunit.xml`.

## Penyimpanan File

File gambar dan dokumen publik disimpan pada:

```text
storage/app/public
```

Pastikan symbolic link berikut tersedia:

```text
public/storage
```

Buat ulang symbolic link jika diperlukan:

```bash
php artisan storage:link
```

Gambar yang diunggah melalui modul terkait diproses menjadi WebP. Beberapa modul juga menyimpan file asli untuk kebutuhan unduhan.

## Konfigurasi Queue

Project menggunakan database queue secara default:

```env
QUEUE_CONNECTION=database
```

Jalankan worker pada lingkungan yang membutuhkan proses antrean:

```bash
php artisan queue:work
```

## Persiapan Production

Sebelum deployment, sesuaikan `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-sekolah.example
```

Gunakan kredensial database dan mail production, kemudian jalankan:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

Pastikan web server mengarah ke folder `public`, permission folder `storage` dan `bootstrap/cache` benar, serta queue worker dijalankan jika diperlukan.

Jangan pernah menyimpan file `.env`, password, application key, atau kredensial production ke repository.
