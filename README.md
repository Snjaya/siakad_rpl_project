# 🏫 SIAKAD SMK Marhas

Sistem Informasi Akademik (SIAKAD) yang dirancang khusus untuk kebutuhan digitalisasi **SMK Marhas**. Aplikasi ini membantu pengelolaan data akademik mulai dari data master, penjadwalan, hingga pelaporan nilai siswa secara real-time.

Dibangun menggunakan teknologi terbaru **Laravel 12** dan **PHP 8.4** dengan antarmuka modern **Emerald Green** yang responsif (Mobile-First Design).

## 🚀 Fitur Utama

### 👨‍💼 Administrator & Tata Usaha (TU)
* **Dashboard Statistik:** Ringkasan jumlah siswa, guru, dan kelas.
* **Manajemen User:** Kelola akun dengan Role (Admin, TU, Guru, Siswa).
* **Data Master:** CRUD Guru, Siswa, Kelas, Mata Pelajaran, dan Tahun Ajaran.
* **Penjadwalan:** Atur jadwal pelajaran anti-bentrok.

### 👨‍🏫 Guru
* **Jadwal Mengajar:** Melihat jadwal harian dan mingguan di dashboard.
* **Input Nilai:** Input nilai Tugas, UTS, dan UAS per kelas.
* **Kalkulasi Otomatis:** Nilai akhir dihitung otomatis (30% Tugas + 30% UTS + 40% UAS).

### 👨‍🎓 Siswa
* **Jadwal Pelajaran:** Melihat jadwal pelajaran aktif hari ini dan minggu ini.
* **Kartu Hasil Studi (KHS):** Melihat transkrip nilai dan grade (A/B/C/D/E) secara real-time.

## 🛠️ Teknologi yang Digunakan
* **Backend:** Laravel 12 (PHP 8.4)
* **Database:** MySQL
* **Frontend:** Blade Templating, Tailwind CSS
* **Icons:** FontAwesome 6
* **Fitur Lain:** Authentication, Pagination, Search, Seeding Data Dummy.

## 💻 Cara Install & Menjalankan (Localhost)

Ikuti langkah ini untuk menjalankan project di laptop Anda:

### 1. Persyaratan Sistem
* PHP >= 8.4
* Composer
* Node.js & NPM
* MySQL

### 2. Instalasi
```bash
# Clone repository
git clone [https://github.com/username-kamu/siakad-smk-marhas.git](https://github.com/username-kamu/siakad-smk-marhas.git)

# Masuk ke folder project
cd siakad-smk-marhas

# Install dependencies
composer install
npm install

# Setup Environment
cp .env.example .env
php artisan key:generate
