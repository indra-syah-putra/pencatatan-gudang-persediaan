<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

# Pencatatan Gudang Persediaan — PT. Jaya Raya

Sistem pencatatan inventaris gudang berbasis web. Dibangun dengan Laravel 10, Tailwind CSS, Alpine.js, dan MySQL.

---

## Fitur

- Login terpisah Admin (biru) & Staff (hijau) dengan captcha matematika
- Dashboard: total barang, stok rendah, daftar barang terbaru
- CRUD barang dengan soft delete
- Transaksi barang masuk & keluar
- Laporan stok PDF per bulan
- Edit profil (nama + foto, hapus foto)
- Pengaturan perusahaan (nama, alamat, telp, email, logo, tanda tangan)

## Kebutuhan Sistem

- PHP 8.1+
- Composer
- MySQL (via Laragon atau XAMPP)
- Node.js & NPM (buat build CSS/JS)

## Cara Install

1. Clone repo
   ```
   git clone https://github.com/indra-syah-putra/pencatatan-gudang-persediaan.git
   cd pencatatan-gudang-persediaan
   ```

2. Install dependency PHP
   ```
   composer install
   ```

3. Copy file env lalu atur database
   ```
   cp .env.example .env
   ```
   Sesuaikan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` di `.env`

4. Generate key
   ```
   php artisan key:generate
   ```

5. Install & build asset
   ```
   npm install
   npm run build
   ```

6. Migrasi database + seeder
   ```
   php artisan migrate --seed
   ```

7. Buat symlink storage
   ```
   php artisan storage:link
   ```

8. Jalankan server
   ```
   php artisan serve
   ```

Akses `http://localhost:8000` di browser.

## User Bawaan (Seeder)

| Role  | Email                  | Password |
|-------|------------------------|----------|
| Admin | admin@jayaraya.com     | password |
| Staff | staff@jayaraya.com     | password |

## Mode Pengembangan (Development)

Untuk masuk ke mode pengembangan agar setiap perubahan kode (baik di backend maupun frontend) bisa langsung terpantau secara *real-time*, kamu perlu menjalankan dua server sekaligus (Laravel Server dan Vite Dev Server).

Jalankan perintah praktis berikut di terminal kamu:

```bash
# Terminal 1: Jalankan server lokal Laravel
php artisan serve

# Terminal 2: Jalankan compiler Vite untuk aset frontend
npm run dev
```

---
## Login

- `/admin/login` — Portal Admin
- `/staff/login` — Portal Staff
- `/login` — Otomatis redirect ke admin

## Struktur Direktori

```
app/
├── Http/Controllers/
│   ├── Admin/Auth/LoginController.php   # Login admin
│   ├── Staff/Auth/LoginController.php   # Login staff
│   ├── BarangController.php             # CRUD barang
│   ├── TransaksiController.php          # Barang masuk/keluar
│   ├── LaporanController.php            # Cetak PDF
│   ├── DashboardController.php          # Dashboard
│   ├── ProfileController.php            # Edit profil
│   └── SettingsController.php           # Pengaturan perusahaan
├── Models/
│   ├── Barang.php
│   ├── Pemasok.php
│   ├── Persediaan.php
│   ├── Transaksi.php
│   └── Setting.php
├── Helpers/
│   ├── helpers.php                      # Fungsi company()
│   └── Settings.php                     # Resolve DB fallback ke config
└── Services/
    └── CaptchaService.php               # Captcha matematika

resources/views/
├── layouts/app.blade.php                # Layout utama
├── auth/
│   ├── admin-login.blade.php            # Halaman login admin
│   └── staff-login.blade.php            # Halaman login staff
├── dashboard.blade.php
├── barang/
├── transaksi/
├── laporan/
├── profile/edit.blade.php
└── settings/index.blade.php

config/company.php                       # Default data perusahaan
routes/web.php                           # Semua route
routes/auth.php                          # Route auth (register, forgot password, dll)
```

## Teknologi

- **Laravel 10** — Backend
- **Tailwind CSS** — Styling (via Vite)
- **Alpine.js** — Interaktivitas frontend
- **MySQL** — Database
- **DomPDF** — Cetak laporan PDF
- **Font Awesome 6** — Icon

## License

[MIT](LICENSE)
