# PRD — Sistem Informasi Magang Mahasiswa (SiMagang)
**Versi:** 1.0 — MVP  
**Status:** Draft  
**Stack:** Laravel (PHP), MySQL

---

## 1. Overview

SiMagang adalah sistem informasi berbasis web (Laravel) yang mengelola seluruh siklus magang mahasiswa — dari pengajuan hingga penilaian akhir. Sistem ini melayani empat pihak: mahasiswa, dosen pembimbing, admin prodi, dan perusahaan mitra. Masalah utama yang diselesaikan: proses administrasi magang yang masih manual (surat fisik, logbook kertas, koordinasi via WhatsApp), tidak ada transparansi status bagi mahasiswa, dan dosen kewalahan memantau banyak mahasiswa sekaligus tanpa dashboard terpusat.

---

## 2. Target Pengguna & Role

| Role | Tanggung Jawab dalam Sistem |
|---|---|
| **Mahasiswa** | Daftar & ajukan magang, isi logbook harian, upload dokumen, pantau status, lihat nilai |
| **Dosen Pembimbing** | Pantau progress mahasiswa bimbingan, beri catatan & persetujuan logbook, input nilai akhir |
| **Admin Prodi** | Kelola data mahasiswa, perusahaan mitra, periode magang; generate surat; ekspor laporan |
| **Perusahaan Mitra** | Verifikasi kehadiran mahasiswa, isi form penilaian dari sisi industri, lihat profil mahasiswa |

---

## 3. Core Features (MVP)

| ID | Fitur | Lingkup / Batasan |
|---|---|---|
| F-01 | Multi-role auth & dashboard | Login, hak akses, dan tampilan berbeda per role |
| F-02 | Pendaftaran & pengajuan magang | Mahasiswa isi form, upload CV + surat; admin proses & ubah status |
| F-03 | Manajemen surat & dokumen | Generate surat pengantar PDF otomatis dari template Blade; mahasiswa download |
| F-04 | Logbook digital harian | Mahasiswa isi kegiatan harian; dosen beri catatan & setujui per minggu |
| F-05 | QR Code presensi | Mahasiswa generate QR unik per hari; petugas/admin scan untuk catat kehadiran |
| F-06 | Penilaian terstruktur | Form penilaian per aspek dari dosen & perusahaan; nilai agregat otomatis |
| F-07 | Notifikasi in-app & email | Notif otomatis: deadline logbook, status berubah, pesan dari dosen/admin |
| F-08 | Laporan & ekspor data | Export daftar mahasiswa, rekap kehadiran, dan nilai ke Excel/PDF |

---

## 4. User Flow Utama

### Mahasiswa — Pengajuan & Pelaksanaan Magang
1. Login → masuk Dashboard (lihat status pengajuan & deadline logbook)
2. Isi form pengajuan: pilih perusahaan, periode, upload CV & surat
3. Admin proses pengajuan → mahasiswa terima notifikasi status (Diterima / Ditolak)
4. Jika diterima → download surat pengantar PDF yang digenerate otomatis
5. Selama magang: isi logbook harian, generate QR presensi setiap hari kerja
6. Dosen beri catatan & setujui logbook mingguan → mahasiswa terima notif
7. Selesai magang → lihat nilai akhir di dashboard, download sertifikat PDF

### Dosen Pembimbing — Monitoring & Penilaian
1. Login → Dashboard: lihat daftar mahasiswa bimbingan & status logbook masing-masing
2. Klik mahasiswa → lihat detail logbook harian yang sudah diisi
3. Tambah catatan per entri logbook → setujui atau minta revisi
4. Setelah periode selesai → isi form penilaian akhir per aspek

### Admin Prodi — Pengelolaan Data & Dokumen
1. Login → Dashboard: ringkasan statistik (total mahasiswa aktif, status pengajuan)
2. Proses pengajuan masuk: ubah status, generate surat pengantar otomatis
3. Kelola data perusahaan mitra & periode magang aktif
4. Ekspor laporan rekap kehadiran dan nilai ke Excel/PDF

### Perusahaan Mitra — Presensi & Penilaian
1. Login → lihat daftar mahasiswa magang aktif di perusahaan
2. Scan QR Code harian mahasiswa → kehadiran tercatat otomatis
3. Di akhir periode → isi form penilaian mahasiswa dari sisi industri

---

## 5. Halaman yang Dibutuhkan

| Role | Halaman / Screen |
|---|---|
| **Semua Role** | Login, Profil & ganti password, Notifikasi |
| **Mahasiswa** | Dashboard (status & deadline), Form pengajuan magang, Upload & kelola dokumen, Logbook harian (list + form tambah), QR Code presensi harian, Status penilaian |
| **Dosen Pembimbing** | Dashboard (daftar mahasiswa bimbingan), Detail mahasiswa + riwayat logbook, Form catatan & persetujuan logbook, Form input nilai akhir |
| **Admin Prodi** | Dashboard (statistik & monitoring), Manajemen mahasiswa, Manajemen perusahaan mitra, Manajemen periode magang, Generate & download surat PDF, Rekap kehadiran, Ekspor laporan (Excel/PDF) |
| **Perusahaan Mitra** | Dashboard (daftar mahasiswa aktif), Scan / verifikasi QR presensi, Form penilaian mahasiswa |

> Total estimasi: ±20 halaman/screen (belum termasuk halaman error 404/403 dan email template).

---

## 6. Out of Scope (untuk sekarang)

- Fitur chat / pesan real-time antar pengguna dalam aplikasi
- AI assistant untuk bantu isi logbook atau rekomendasi perusahaan
- Integrasi dengan LinkedIn atau platform karir eksternal
- WhatsApp Bot untuk isi logbook via chat
- Gamifikasi (leaderboard, poin, badge)
- Sistem seleksi / tes online untuk calon peserta magang
- Mood tracker / wellbeing monitoring mahasiswa
- Fitur multi-tenant (sistem ini untuk satu prodi/kampus dulu)
- Mobile app native (Android / iOS) — cukup responsive web

> Fitur-fitur di atas dapat dipertimbangkan di v2 setelah MVP selesai dan ada feedback pengguna nyata.
