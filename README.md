# SiMagang — Sistem Informasi Magang Mahasiswa

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)

**🚀 Live Production URL:** [https://simagang-production.up.railway.app/](https://simagang-production.up.railway.app/)

SiMagang adalah platform digital terintegrasi berbasis Laravel yang dirancang khusus untuk memfasilitasi administrasi, monitoring, dan evaluasi program magang mahasiswa. Sistem ini menghubungkan empat pilar utama — **Admin Prodi, Dosen Pembimbing, Perusahaan Mitra, dan Mahasiswa** — dalam satu pintu, menciptakan transparansi dan efisiensi manajemen magang kampus dari awal pendaftaran hingga pelaporan nilai akhir.

---

## 🛠 Tech Stack

| Layer | Teknologi |
|---|---|
| Framework | Laravel 13.x |
| Runtime | PHP 8.3+ |
| Database | MySQL 8.0 |
| Frontend | Vanilla CSS (custom design system), Alpine.js, SweetAlert2 |
| Auth & Role | spatie/laravel-permission ^8.0 |
| PDF | barryvdh/laravel-dompdf ^3.1 |
| Excel Export | maatwebsite/excel |
| QR Code | simplesoftwareio/simple-qrcode ^4.2 |

---

## ✨ Fitur MVP (8 Fitur)

| # | Fitur | Deskripsi |
|---|---|---|
| F-01 | **Multi-Role Auth & Dashboard** | Login per role (Admin, Dosen, Perusahaan, Mahasiswa). Dashboard dinamis dengan data real-time dari DB. |
| F-02 | **Pendaftaran & Pengajuan Magang** | Mahasiswa mengajukan magang, upload dokumen syarat. Admin approve/reject & assign dosen pembimbing. |
| F-03 | **Surat & Dokumen + Sertifikat** | Surat pengantar PDF otomatis saat approved. Sertifikat magang PDF setelah status `completed`. |
| F-04 | **Logbook Digital Harian** | Mahasiswa isi laporan harian (draft/submit). Dosen review & approve/revisi dengan catatan. |
| F-05 | **QR Code Presensi** | Mahasiswa generate QR unik harian. Perusahaan scan/input token untuk verifikasi kehadiran. |
| F-06 | **Penilaian Terstruktur** | Dosen dan Perusahaan masing-masing input 5 aspek nilai (0–100). Nilai akhir = rata-rata keduanya. |
| F-07 | **Notifikasi In-App** | Notifikasi database driver untuk: pengajuan approved/rejected, logbook di-review, nilai masuk. |
| F-08 | **Laporan & Ekspor** | Export rekap presensi & nilai ke Excel. Laporan akhir per mahasiswa ke PDF. |

---

## 📋 Requirements

- PHP >= 8.3
- Composer
- MySQL 8.0

---

## 🚀 Instalasi & Setup

```bash
# 1. Clone project
git clone https://github.com/ajiarl/simagang.git
cd simagang

# 2. Install PHP dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan sesuaikan koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simagang
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 5. Migrate & seed database
php artisan migrate:fresh --seed

# 6. Jalankan development server
php artisan serve
```

Buka: **http://localhost:8000**

---

## 👥 Akun Default (Setelah Seeding)

| Email | Password | Role | Akses Utama |
|---|---|---|---|
| admin@simagang.test | password | Admin Prodi | Kelola pengajuan, mahasiswa, perusahaan, periode, laporan |
| dosen@simagang.test | password | Dosen Pembimbing | Review logbook, input nilai, pantau mahasiswa bimbingan |
| mhs1@simagang.test | password | Mahasiswa | Ajukan magang, isi logbook, presensi QR, lihat nilai |
| mhs2@simagang.test | password | Mahasiswa | Sama dengan mhs1 |
| company@simagang.test | password | Perusahaan Mitra | Verifikasi presensi, input penilaian mahasiswa |

> **Catatan:** Untuk test fitur logbook, presensi, dan dokumen, `mhs1` membutuhkan `InternshipApplication` dengan status `approved`. Lihat `docs/HANDOFF.md` Section 13 untuk perintah tinker.

---

## 📁 Dokumentasi

Dokumentasi lengkap tersedia di folder [`docs/`](./docs/):

| File | Isi |
|---|---|
| [`docs/HANDOFF.md`](./docs/HANDOFF.md) | Panduan handoff: controller, route, DB, keputusan teknis |
| [`docs/POLISH_PLAN.md`](./docs/POLISH_PLAN.md) | Gap analysis & status penyelesaian |
| [`docs/PRD_SiMagang_v1.md`](./docs/PRD_SiMagang_v1.md) | Product Requirements Document |
| [`docs/DESIGN.md`](./docs/DESIGN.md) | Design system (warna, tipografi, komponen) |
