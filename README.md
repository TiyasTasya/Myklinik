# 🏥 Myklinik - Sistem Informasi Manajemen Klinik & Rekam Medis

**Myklinik** adalah aplikasi Sistem Informasi Manajemen Klinik modern berbasis web yang dirancang untuk mengelola operasional klinik, rekam medis pasien, data kepegawaian, inventaris farmasi/barang, serta integrasi data wilayah Indonesia secara komprehensif.

Dibangun menggunakan stack teknologi terkini: **Laravel 13**, **Filament v5**, **Livewire 3**, **Tailwind CSS**, dan basis data **MySQL**.

---

## 🌟 Fitur Utama

### 1. 📋 Manajemen Pasien & Rekam Medis
- **Nomor Rekam Medis (No. RM)** otomatis dan unik.
- **Data Identitas Lengkap**: Gelar depan/belakang, nama lengkap, nama panggilan, tempat lahir, tanggal lahir, jenis kelamin, agama, status perkawinan, pendidikan, pekerjaan, golongan darah, suku bangsa, dan kewarganegaraan.
- **Asal Instansi & Unit Eksternal**: Keterikatan unit dan sub-unit pengirim/asal pasien.
- **Identitas & Alamat Berjenjang**:
  - Alamat KTP dan Alamat Domisili Sekarang (dengan fitur *Sama Dengan Alamat Sekarang*).
  - Integrasi cascade wilayah: Provinsi &rarr; Kabupaten/Kota &rarr; Kecamatan &rarr; Kelurahan/Desa beserta RT, RW, dan Kode Pos.
- **Kontak & Data Keluarga**:
  - Multi-kontak pasien (Telepon, WhatsApp, Email, dll.).
  - Data keluarga pasien beserta status hubungan dalam keluarga (SHDK), pendidikan, pekerjaan, alamat, dan nomor kontak.
- **Infolist Pasien**: Ringkasan data pasien dalam satu tampilan tabel kartu identitas yang rapi.

### 2. 👥 Manajemen Pengguna (*Cluster*)
- **Data Pegawai**:
  - Pengelolaan NIP, nama lengkap, gelar, tempat & tanggal lahir, jenis kelamin, dan agama.
  - Klasifikasi profesi medis & non-medis (Dokter, Perawat, Bidan, Farmasi, Administrasi, dll.).
  - Pengelolaan data legalitas profesi: No. STR, masa berlaku STR, No. SIP, dan masa berlaku SIP.
  - Penempatan Poli dan spesialisasi/subspesialisasi dokter.
  - Penautan akun login pengguna sistem (*opsional*).
- **Pengguna Sistem (Users)**: Manajemen akun login dengan otentikasi aman.
- **Hak Akses & Peran (Roles & Permissions)**:
  - Manajemen peran (*Role-Based Access Control*) berbasis **Filament Shield**.
  - Otorisasi granular untuk setiap Resource, Halaman (*Pages*), dan Widget.

### 3. 📦 Manajemen Barang & Farmasi (*Cluster*)
- **Master Barang & Obat**: Pencatatan data inventaris medis/non-medis, kode barang, harga, dan stok.
- **Kategori Barang**: Klasifikasi jenis barang/obat.
- **Satuan Barang**: Konversi dan penentuan satuan (Strip, Box, Botol, Tablet, Pcs, dll.).
- **Penyedia / Vendor**: Direktori distributor dan supplier obat/peralatan medis.

### 4. 🗺️ Data Wilayah Indonesia (*Cluster*)
- Menggunakan basis data resmi **91.162+ wilayah Indonesia** dari paket `aliziodev/laravel-indonesia-regions`.
- **Daftar Provinsi**: 38 Provinsi dengan kode wilayah standar BPS/Kemendagri.
- **Daftar Kabupaten / Kota**: Seluruh kota/kabupaten terintegrasi per provinsi.
- **Daftar Kecamatan**: Pencarian dan pengelolaan kecamatan per kab/kota.
- **Daftar Desa / Kelurahan**: Database lengkap kelurahan dan desa beserta kode pos.
- Dilengkapi proteksi otorisasi halaman (*Page Shield*).

### 5. ⚙️ Master Pengaturan (*Cluster*)
- **Pengaturan (*Cluster*)**:
  - **Umum & Branding**: Pengelolaan nama klinik/aplikasi, logo aplikasi (Light & Dark Mode), ukuran logo, dan favicon browser secara langsung melalui panel admin.
- **Poli / Unit Layanan**: Pengaturan poli klinik (Poli Umum, Gigi, KIA, dll.).
- **Tindakan Medis**: Tarif dan katalog tindakan medis dokter/perawat.
- **Unit Kerja / Eksternal**: Pengelolaan struktur unit dan sub-unit organisasi.
- **Referensi Detail Dinamis**: Nilai referensi fleksibel untuk Agama, Status Pernikahan, Pendidikan, Pekerjaan, Golongan Darah, Suku, Jenis Kontak, Jenis Kartu Identitas, dll.
- **Negara (Country)**: Database negara dunia beserta bendera dan dial code.

---

## 🛠️ Persyaratan Sistem

- **PHP**: `^8.3` (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`, `intl`, `fileinfo`)
- **Web Server**: Apache / Nginx / Laragon
- **Database**: MySQL `^8.0` / MariaDB `^10.4`
- **Composer**: `^2.5`
- **Node.js**: `^20.x` & **NPM**: `^10.x`

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi

### 1. Clone Repository
```bash
git clone https://github.com/TiyasTasya/Myklinik.git
cd Myklinik
```

### 2. Install Dependensi PHP & Node
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi environment dan sesuaikan kredensial database Anda:
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan baris berikut pada file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migrasi Basis Data & Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 5. Sinkronisasi Data Wilayah Indonesia
Sinkronisasikan seluruh 91.162 data wilayah Indonesia:
```bash
php artisan indonesia-regions:sync
```

### 6. Generate Hak Akses & Super Admin Shield
```bash
# Generate seluruh permission & policy Filament Shield
php artisan shield:generate --all --panel=admin --option=policies_and_permissions --no-interaction

# Buat akun Super Admin pertama Anda
php artisan shield:super-admin
```

### 7. Build Aset Frontend
```bash
# Untuk mode pengembangan (hot reload):
npm run dev

# Atau untuk mode produksi:
npm run build
```

### 8. Jalankan Server Aplikasi
```bash
php artisan serve
```
Akses panel admin di browser Anda: **`http://127.0.0.1:8000/admin`**

---

## 📂 Struktur Direktori Utama

```
Myklinik/
├── app/
│   ├── Filament/
│   │   ├── Clusters/
│   │   │   ├── ManajemenBarang.php      # Cluster inventaris & farmasi
│   │   │   ├── ManajemenPengguna.php    # Cluster pegawai, user, & peran
│   │   │   └── Wilayah.php              # Cluster data wilayah Indonesia
│   │   │       └── Pages/               # Halaman Provinsi, Kab/Kota, Kec, Desa
│   │   ├── Resources/                   # Filament Resources (Pasien, Pegawai, dll.)
│   │   │   ├── Pasiens/                 # Resource Pasien & Form Berjenjang
│   │   │   ├── Pegawais/                # Resource Pegawai
│   │   │   ├── Roles/                   # Custom Role & Shield Resource
│   │   │   └── Users/                   # Resource Akun Pengguna
│   │   └── Widgets/                     # Dashboard & Analytics Widgets
│   ├── Models/                          # Eloquent Models (Pasien, Pegawai, Region, dll.)
│   ├── Policies/                        # Laravel Authorization Policies
│   └── Providers/
│       └── Filament/
│           └── AdminPanelProvider.php   # Konfigurasi Panel Admin Filament
├── database/
│   ├── migrations/                      # Skema migrasi basis data
│   └── seeders/                         # Seeder data awal
├── lang/
│   └── vendor/filament-shield/          # Override terjemahan Filament Shield
├── public/                              # Aset publik, logo, & profil ikon
└── routes/
    └── web.php                          # Rute aplikasi
```

---

## 🔒 Manajemen Keamanan & Hak Akses (Shield)

Aplikasi menggunakan **Filament Shield** untuk sistem kontrol akses berbasis peran (RBAC):
- **Super Admin**: Memiliki akses tak terbatas ke seluruh fitur dan pengaturan sistem.
- **Role Kustom**: Hak akses dapat dikonfigurasi secara mandiri melalui menu **Manajemen Pengguna > Peran**:
  - Tab **Resources**: Izin CRUD untuk Pasien, Pegawai, User, Barang, Poli, dll.
  - Tab **Pages**: Izin akses untuk modul Halaman (misal: Daftar Provinsi, Kabupaten, Kecamatan, Desa).
  - Tab **Widgets**: Izin menampilkan widget tertentu pada Dashboard.

---

## 📄 Lisensi

Proyek ini dikembangkan di bawah lisensi [MIT License](LICENSE).
