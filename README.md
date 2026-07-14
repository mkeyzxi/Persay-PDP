# PRISAY-PDP (Project Information System - Pekerjaan Dalam Pelaksanaan)

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-Volt%20%7C%20Flux-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)

**PRISAY-PDP** adalah Sistem Informasi Manajemen Pekerjaan Dalam Pelaksanaan berbasis website yang dirancang untuk mengintegrasikan seluruh proses pengelolaan proyek konstruksi dan pengadaan barang/jasa, mulai dari Divisi Logistik, Konstruksi, hingga Akuntansi dalam satu platform terpusat.

## 📖 Latar Belakang & Tujuan
Pengelolaan proyek seringkali menghadapi tantangan seperti data yang tersebar, kesulitan tracking material dari SAP, hingga pencatatan *asset number* yang manual dan rawan kesalahan. 

Sistem ini hadir dengan tujuan:
- Menyediakan platform terpusat untuk memantau *progress* proyek secara *real-time*.
- Mengintegrasikan data dari Logistik, Konstruksi, dan Akuntansi.
- Mempermudah validasi, pencatatan *asset*, dan proses penutupan (closing) proyek secara paperless dan akurat.

## ✨ Fitur Utama
- **Dashboard Analitik**: Ringkasan status seluruh proyek (aktif/selesai), tren keuangan, dan klasterisasi umur proyek.
- **Upload Data SAP**: Import data *material issue* langsung dari file Excel (SAP) secara otomatis.
- **Manajemen Proyek & Material**: Input data manual untuk WBS, SPK, Vendor, dan Material.
- **My Take List**: Manajemen tugas spesifik per divisi:
  - **Konstruksi**: Input fisik terpasang dan unggah dokumentasi lapangan.
  - **Akuntansi**: Pencatatan *Asset Number* per material.
- **Rekapitulasi Proyek**: Data selisih material SAP vs Fisik Terpasang (dilengkapi indikator warna).
- **Manajemen Dokumen**: Penyimpanan dokumen legal seperti SPK, BASTP, SLO, dll.
- **Penutupan Proyek Terotentikasi**: Validasi kelengkapan data *asset number* sebelum proyek dinyatakan selesai (CLOSED).

## 👥 Hak Akses Pengguna
Sistem membagi pengguna ke dalam 4 *role* utama:
1. **Administrator**: Akses penuh ke seluruh sistem, manajemen user, dan data master.
2. **User Logistik**: Mengunggah data material dari SAP (Excel) dan mengelola data awal proyek.
3. **User Konstruksi**: Mencatat *progress* fisik terpasang dan mengunggah dokumentasi lapangan.
4. **User Akuntansi**: Memvalidasi data, mencatat nomor *asset* (Asset Number), dan melakukan proses *Closing* proyek.

## 🔄 Alur Kerja Sistem (Workflow)
1. **Input Data**: Logistik mengunggah data SAP Excel atau input proyek manual.
2. **Verifikasi**: Sistem menyimpan data material dan proyek (Dapat diverifikasi bersama).
3. **Progress Lapangan**: Konstruksi mengisi data fisik material terpasang dan dokumentasi.
4. **Pencatatan Asset**: Akuntansi menginput nomor asset untuk material yang telah terpasang.
5. **Validasi**: Sistem memastikan semua material terpasang telah memiliki nomor asset.
6. **Closing**: Akuntansi menutup proyek (Status: CLOSED).

## 🛠️ Teknologi yang Digunakan
- **Backend**: PHP 8.2+, Laravel 12.0
- **Frontend**: Livewire Volt 1.7, Livewire Flux 2.9, Tailwind CSS 4.0, Vite
- **Database**: MySQL / MariaDB (SQLite didukung untuk lokal)
- **Paket Tambahan Utama**: Maatwebsite Excel (Eksport/Import), Laravel Fortify (Autentikasi)

## 🚀 Instalasi & Setup Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (MySQL/SQLite)

### Langkah-langkah
1. **Clone repositori**
   ```bash
   git clone <repo-url> prisay-pdp
   cd prisay-pdp
   ```

2. **Install Dependensi PHP & Node**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   Salin `.env.example` menjadi `.env` lalu sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   ```
   Atau jika menggunakan Windows:
   ```bash
   copy .env.example .env
   ```

4. **Generate App Key & Migrasi Database**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```
   *(Catatan: Tambahkan `--seed` jika Anda memiliki seeder bawaan)*

5. **Build Asset Frontend**
   ```bash
   npm run build
   ```

6. **Jalankan Server Lokal**
   Anda bisa menggunakan command dev bawaan yang sudah diatur dengan `concurrently`:
   ```bash
   composer run dev
   ```
   Atau menjalankan artisan serve secara manual:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses pada `http://localhost:8000`.

## 📚 Dokumentasi Lanjutan
Untuk memahami lebih dalam mengenai arsitektur sistem dan database, silakan merujuk ke dokumen berikut yang tersedia di dalam *root directory* proyek:
- `DOKUMENTASI_SISTEM.txt` - Panduan lengkap mengenai rancangan dan fungsi sistem.
- `DOKUMENTASI_DATABASE.txt` - Struktur relasi dan kamus data database (ERD).
- `REKAP-DASHBOARD-DOCS.md` - Rumus perhitungan teknis dan logika yang digunakan pada modul Dashboard.

---
*Dikembangkan tahun 2026 untuk mengelola Pekerjaan Dalam Pelaksanaan dengan lebih efisien.*
