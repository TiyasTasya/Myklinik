# 🏥 MyKlinik — Sistem Informasi Klinik

Aplikasi administrasi klinik berbasis web yang dibangun dengan **Laravel 13**, **Filament v5**, dan **Livewire**. Dilengkapi dengan manajemen data wilayah Indonesia (Provinsi, Kabupaten/Kota, Kecamatan, Desa/Kelurahan) yang terintegrasi.

---

## ✨ Fitur Utama

- 🔐 **Autentikasi** — Login admin dengan sistem session yang aman
- 👥 **Manajemen User** — CRUD pengguna admin sistem
- 🗺️ **Data Wilayah Indonesia** — Manajemen lengkap 4 level wilayah:
  - Provinsi
  - Kabupaten / Kota
  - Kecamatan
  - Desa / Kelurahan
- ➕ **Tambah Wilayah Baru** — Form tambah/edit/hapus dengan kode otomatis
- 🔍 **Pencarian & Sorting** — Fitur search dan sortir di semua tabel
- 📄 **Pagination Bernomor** — Navigasi halaman tabel yang nyaman
- 🌙 **Dark Mode** — Tampilan gelap bawaan Filament
- 📱 **Responsive** — Tampilan adaptif untuk berbagai ukuran layar

---

## 🛠️ Teknologi

| Teknologi | Versi |
|---|---|
| PHP | ^8.3 |
| Laravel | ^13.17 |
| Filament | ^5.7 |
| Livewire Volt | ^1.11 |
| Tailwind CSS | ^4.3 |
| Vite | ^8.0 |
| IndoRegion | ^3.0 |

---

## 📋 Persyaratan Sistem

Sebelum instalasi, pastikan environment Anda memiliki:

- **PHP** >= 8.3 dengan ekstensi: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM** >= 9.x
- **MySQL** >= 8.0 (atau MariaDB >= 10.4)
- **Web server**: Apache / Nginx / Laragon / XAMPP

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/myklinik.git
cd myklinik
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Salin File Konfigurasi

```bash
cp .env.example .env
```

> Windows: `copy .env.example .env`

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myklinik
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan:** Buat database `myklinik` di MySQL terlebih dahulu.

### 6. Jalankan Migrasi

```bash
php artisan migrate
```

### 7. Seed Data Wilayah Indonesia

```bash
php artisan indoregion:seed
```

> Proses ini akan mengisi ±83.000+ data desa/kelurahan. Mohon tunggu beberapa menit.

### 8. Install Dependensi Frontend

```bash
npm install
npm run build
```

### 9. Buat Akun Admin

```bash
php artisan make:filament-user
```

Isi nama, email, dan password sesuai kebutuhan.

### 10. Jalankan Aplikasi

```bash
php artisan serve
```

Akses di: **http://127.0.0.1:8000/admin**

---

## ⚡ Instalasi Cepat

Jika sudah mengatur `.env` dengan benar:

```bash
composer run setup
```

---

## 📁 Struktur Folder Penting

```
myklinik/
├── app/
│   ├── Filament/
│   │   ├── Clusters/
│   │   │   └── Wilayah/            # Cluster menu Wilayah
│   │   │       └── Pages/          # Halaman Provinsi, Regency, dll.
│   │   └── Resources/
│   │       └── Users/              # CRUD manajemen user
│   ├── Livewire/
│   │   └── Wilayah/                # TableWidget tiap level wilayah
│   └── Models/
│       ├── Province.php
│       ├── Regency.php
│       ├── District.php
│       └── Village.php
└── resources/views/filament/
    └── clusters/wilayah/           # Blade view tiap halaman wilayah
```

---

## 🗺️ Panduan Modul Wilayah

### Membuka Data Wilayah
1. Login ke `/admin`
2. Klik menu **Wilayah** di sidebar
3. Pilih sub-menu: **Provinsi**, **Kabupaten/Kota**, **Kecamatan**, atau **Desa/Kelurahan**

### Menambah Wilayah Baru
1. Klik tombol **"Tambah ..."** di pojok kanan atas tabel
2. Pilih **induk wilayah** (misal pilih Provinsi untuk menambah Kab/Kota)
3. **Kode** akan terisi **otomatis** berdasarkan induk yang dipilih
4. Isi **nama** wilayah, lalu klik **Create**

### Format Kode Wilayah (Standar Kemendagri)

| Level | Panjang | Contoh |
|---|---|---|
| Provinsi | 2 digit | `11` |
| Kabupaten/Kota | 4 digit | `1101` |
| Kecamatan | 7 digit | `1101010` |
| Desa/Kelurahan | 10 digit | `1101010001` |

---

## 🐛 Troubleshooting

| Masalah | Solusi |
|---|---|
| `Class not found` | `composer dump-autoload` |
| `View not found` | `php artisan view:clear` |
| `Vite manifest not found` | `npm run build` |
| Cache lama / tabel tidak muncul | `php artisan optimize:clear` |

---

## 📄 Lisensi

Proyek ini menggunakan lisensi **MIT**.

---

## 🙏 Kredit

- [Laravel](https://laravel.com) — PHP Framework
- [Filament](https://filamentphp.com) — Admin Panel
- [IndoRegion](https://github.com/azishapidin/indoregion) — Data Wilayah Indonesia
- [Livewire](https://livewire.laravel.com) — Reactive Components

---

<p align="center">Dibuat dengan ❤️ menggunakan Laravel & Filament</p>
