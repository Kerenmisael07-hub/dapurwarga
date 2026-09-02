<div align="center">

# 🍽️ Dapurwarga

**Platform jual-beli kuliner & UMKM warga berbasis komunitas.**

Dibangun dengan [Laravel 12](https://laravel.com) dan [MySQL](https://www.mysql.com/) (via XAMPP).

</div>

---

## Tentang Dapurwarga

**Dapurwarga** adalah platform web yang menghubungkan para pelaku **UMKM kuliner** dengan warga sekitar. Website ini memungkinkan penjual (seller) untuk menampilkan dan menjual produk mereka, sementara admin & superadmin mengelola jalannya platform agar tetap tertib dan terpercaya.

Tujuan utama Dapurwarga adalah mendukung **ekonomi lokal** dengan mempermudah warga menemukan dan membeli produk kuliner dari lingkungan mereka sendiri.

## Fitur Utama

- 🛒 **Toko online kuliner/UMKM** — penjual dapat menampilkan produk mereka.
- 👥 **Sistem peran (Role) pengguna**:
  - **Superadmin** — kendali penuh atas platform.
  - **Admin** — mengelola data dan operasional harian.
  - **Seller** — mengelola produk dan penjualan.
- 🔐 **Autentikasi & registrasi pengguna** — login dan daftar akun.
- 🖥️ **Dashboard terpisah** untuk setiap peran (superadmin, admin, seller).
- 🗄️ **Manajemen data** memakai Eloquent ORM dan migrasi `Laravel`.

## Teknologi yang Digunakan

| Teknologi | Fungsi |
|-----------|--------|
| [Laravel 12](https://laravel.com) | Framework web (PHP) |
| PHP 8.2 | Bahasa pemrograman |
| MySQL (XAMPP) | Basis data |
| Blade | Template engine |
| Vite | Bundling aset (CSS/JS) |

## Persyaratan

- PHP 8.2+
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL) atau server MySQL
- [Composer](https://getcomposer.org/)
- [Node.js + npm](https://nodejs.org/) (untuk Vite, opsional)

## Cara Menjalankan di Lokal

1. **Kloning repositori**

   ```bash
   git clone https://github.com/kerenmisael07-hub/dapurwarga.git
   cd dapurwarga
   ```

2. **Install dependency**

   ```bash
   composer install
   npm install
   ```

3. **Aktifkan MySQL (Apache & MySQL di XAMPP)**

   Buka **XAMPP Control Panel**, lalu klik **Start** pada **Apache** dan **MySQL**.

4. **Buat database**

   Buka [phpMyAdmin](http://localhost/phpmyadmin) (atau jalankan perintah MySQL):

   ```sql
   CREATE DATABASE dapurwarga;
   ```

   Atau lewat baris perintah:

   ```bash
   mysql -u root -e "CREATE DATABASE dapurwarga"
   ```

   Jika ada error `could not find driver` atau `Table doesn't exist in engine`, coba bersihkan folder database lalu `DROP DATABASE` & buat ulang (lihat catatan di bawah).

5. **Konfigurasi `.env`**

   Salin `.env.example` menjadi `.env`, lalu sesuaikan pengaturan database:

   ```bash
   cp .env.example .env
   ```

   Contoh konfigurasi MySQL (XAMPP):

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dapurwarga
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   > ⚠️ File `.env` **tidak di-push** ke GitHub karena berisi konfigurasi rahasia. Buat sendiri saat men-deploy.

4. **Generate key aplikasi**

   ```bash
   php artisan key:generate
   ```

5. **Jalankan migrasi database**

   ```bash
   php artisan migrate
   ```

   > **Catatan penting**: Jika menemukan error seperti **`could not find driver`** atau **`Table '...' doesn't exist in engine`**:
   >
   > - Pastikan ekstensi `pdo_mysql` aktif di `php.ini` (`extension=pdo_mysql`).
   > - Hentikan PHP server yang berjalan, lalu mulai ulang dengan `php artisan serve`.
   > - Jika database rusak/korup, hapus folder `C:\xampp\mysql\data\dapurwarga`, buat ulang database `dapurwarga`, lalu jalankan `php artisan migrate` lagi.

6. **Jalankan server**

   ```bash
   php artisan serve
   ```

   Lalu buka `http://127.0.0.1:8000` di browser.

## Struktur Direktori

```
app/
├─ Http/Controllers/
│  └─ Auth/            # Login & Register
├─ Models/
├─ Providers/
config/                # Konfigurasi aplikasi
database/              # Migrasi & seeder
public/                # Entry point (index.php)
resources/views/
├─ auth/               # Halaman login & register
├─ superadmin/         # Dashboard superadmin
├─ admin/              # Dashboard admin
├─ seller/             # Dashboard seller
routes/                # Definisi rute
```

## Lisensi

Proyek ini dibangun di atas [Laravel](https://laravel.com) yang dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
