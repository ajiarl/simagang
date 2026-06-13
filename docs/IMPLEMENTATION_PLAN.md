# IMPLEMENTATION_PLAN.md — SiMagang
> Rencana implementasi teknis per fase. Baca sebelum mulai coding tiap fase.
> Update status (⏳ / ✅ / ❌) setiap kali fase selesai.

---

## Aturan Wajib di Setiap Prompt Antigravity

Selalu taruh ini di **awal setiap prompt**:

```
IMPORTANT CONSTRAINTS:
- Read DESIGN.md and PRD_SiMagang_v1.md before doing anything
- Use DESIGN.md as single source of truth for all UI styling
- Use PRD_SiMagang_v1.md as single source of truth for features & business logic
- Do NOT modify .env file
- Do NOT change DB_CONNECTION from mysql
- If any error occurs, stop and report — do not change config files
```

---

## Status Fase

| Fase | Nama | Status |
|---|---|---|
| 0 | Fondasi | ✅ Selesai |
| 1 | Auth & Dashboard | ✅ Selesai |
| 2 | Pengajuan Magang + Surat PDF | ✅ Selesai |
| 3 | Logbook Digital | ✅ Selesai |
| 4 | QR Code Presensi | ✅ Selesai |
| 5 | Penilaian | ✅ Selesai |
| 6 | Notifikasi & Laporan | ✅ Selesai |

---

## Fase 0 — Fondasi

**Tujuan:** Semua scaffolding siap sebelum mulai fitur apapun.

### Checklist
- [x] DESIGN.md di-fetch dari Stitch MCP
- [x] Semua migrasi dibuat & dijalankan di MySQL
- [x] Spatie Laravel Permission terinstall & ter-migrate
- [x] HasRoles trait ditambahkan ke User model
- [x] Tailwind + Vite terkonfigurasi & styling muncul di browser
- [x] `layouts/app.blade.php` selesai (sidebar + header)
- [x] DatabaseSeeder selesai & berhasil di-seed
- [x] Login berfungsi, redirect per role benar
- [x] Dashboard placeholder per role tampil dengan benar

### Tabel Database yang Harus Ada
```
users, cache, cache_locks, failed_jobs, jobs, job_batches,
migrations, password_reset_tokens, sessions,
roles, permissions, model_has_roles, model_has_permissions, role_has_permissions,
companies, internship_periods, internship_applications,
documents, logbooks, attendances, assessments
```

### Akun Seeder
| Email | Password | Role |
|---|---|---|
| admin@simagang.test | password | admin |
| dosen@simagang.test | password | dosen |
| mhs1@simagang.test | password | mahasiswa |
| mhs2@simagang.test | password | mahasiswa |
| company@simagang.test | password | perusahaan |

### Prompt Antigravity — Fix Tailwind/Vite
```
[CONSTRAINTS]

The login page has no styling. Fix Tailwind + Vite setup:

1. resources/css/app.css must contain:
   @tailwind base;
   @tailwind components;
   @tailwind utilities;

2. tailwind.config.js content array must include:
   './resources/**/*.blade.php',
   './resources/**/*.js'

3. login.blade.php must use @vite directive in <head>, NOT CDN.
4. layouts/app.blade.php must use @vite directive, NOT CDN.
5. Do NOT use <script src="https://cdn.tailwindcss.com">.
```

### Prompt Antigravity — Base Layout + Seeder
```
[CONSTRAINTS]

Phase 0, Step 3: Base Layout + Seeder.

1. Create resources/views/layouts/app.blade.php:
   - Collapsible left sidebar (desktop) / hamburger (mobile)
   - Top header: page title (left), notification bell + user avatar 
     with dropdown logout (right)
   - Main content area with @yield('content')
   - Sidebar items by @role:
     mahasiswa: Dashboard, Pengajuan Magang, Logbook, Presensi, Dokumen, Penilaian
     dosen: Dashboard, Mahasiswa Bimbingan, Logbook Review, Input Nilai
     admin: Dashboard, Mahasiswa, Perusahaan, Periode, Surat & Dokumen, Rekap, Laporan
     perusahaan: Dashboard, Verifikasi Presensi, Penilaian Mahasiswa
   - Style sesuai DESIGN.md

2. DatabaseSeeder:
   - 4 roles: mahasiswa, dosen, admin, perusahaan
   - 1 admin: admin@simagang.test / password
   - 1 dosen: dosen@simagang.test / password
   - 2 mahasiswa: mhs1@simagang.test, mhs2@simagang.test / password
   - 1 perusahaan: company@simagang.test / password
   - 2 sample companies
   - 1 active internship period

3. Routes, controllers, placeholder dashboard per role.
   Setelah login → redirect ke dashboard masing-masing.
   Dashboard: 3-4 stat cards placeholder, styled dengan DESIGN.md.

4. Run: php artisan db:seed
5. Run: php artisan serve

Do NOT run migrate atau migrate:fresh.
```

---

## Fase 1 — Auth & Dashboard

**Tujuan:** Login berfungsi penuh, setiap role punya dashboard yang informatif.

**Depends on:** Fase 0 selesai 100%

**Deliverable yang bisa ditest:**
- Login dengan 5 akun berbeda → masing-masing dapat tampilan berbeda
- Logout berfungsi
- Akses URL role lain → redirect ke dashboard sendiri (middleware)

### Checklist
- [x] Login page final (styled sesuai DESIGN.md)
- [x] Middleware per role (Spatie Role Middleware)
- [x] Dashboard Mahasiswa: status pengajuan, logbook hari ini, presensi bulan ini
- [x] Dashboard Dosen: jumlah mahasiswa bimbingan, logbook pending review
- [x] Dashboard Admin: total mahasiswa aktif, perusahaan mitra, periode aktif
- [x] Dashboard Perusahaan: mahasiswa magang saat ini, presensi hari ini

### Prompt Antigravity
```
[CONSTRAINTS]

Phase 1: Auth & Dashboard.

1. Ensure login middleware redirects each role correctly:
   mahasiswa → /mahasiswa/dashboard
   dosen → /dosen/dashboard
   admin → /admin/dashboard
   perusahaan → /perusahaan/dashboard

2. Create role-based middleware to protect each route group.
   Unauthorized access redirects to their own dashboard.

3. Build real dashboard views (not placeholder) per role:
   
   Mahasiswa dashboard:
   - Card: Status pengajuan magang (badge: draft/submitted/approved)
   - Card: Logbook hari ini (sudah diisi / belum)
   - Card: Total kehadiran bulan ini
   - Card: Nilai sementara (jika ada)
   
   Dosen dashboard:
   - Card: Jumlah mahasiswa bimbingan aktif
   - Card: Logbook pending review (dengan badge angka)
   - Card: Mahasiswa yang belum input nilai
   - List: 5 logbook terbaru yang perlu direview
   
   Admin dashboard:
   - Card: Total mahasiswa magang aktif
   - Card: Total perusahaan mitra
   - Card: Periode magang aktif
   - Card: Pengajuan pending approval
   
   Perusahaan dashboard:
   - Card: Mahasiswa magang aktif di perusahaan ini
   - Card: Presensi hari ini (sudah/belum diverifikasi)
   - List: Mahasiswa magang beserta status presensi

4. All views extend layouts.app and use DESIGN.md styling.
```

---

## Fase 2 — Pengajuan Magang + Surat PDF

**Tujuan:** Mahasiswa bisa ajukan magang, admin approve, surat PDF ter-generate otomatis.

**Depends on:** Fase 1 selesai

**Deliverable yang bisa ditest:**
- Mahasiswa isi form pengajuan → submit → status: submitted
- Admin lihat list pengajuan → approve/reject
- Setelah approved → surat pengantar PDF bisa didownload

### Checklist
- [x] Form pengajuan magang (mahasiswa) — pilih perusahaan & periode
- [x] Upload dokumen syarat (KTM, surat permohonan)
- [x] Halaman status pengajuan (tracking)
- [x] Admin: list semua pengajuan + filter status
- [x] Admin: approve/reject dengan alasan
- [x] Admin: assign dosen pembimbing
- [x] Generate surat pengantar PDF (barryvdh/laravel-dompdf)
- [x] Download surat dari halaman dokumen mahasiswa

### Prompt Antigravity
```
[CONSTRAINTS]

Phase 2: Pengajuan Magang + Surat PDF.

Install dompdf if not installed:
composer require barryvdh/laravel-dompdf

Build these features:

MAHASISWA:
1. Form pengajuan magang (InternshipApplicationController@create):
   - Pilih perusahaan mitra (dropdown dari companies table)
   - Pilih periode magang (dropdown dari internship_periods yang aktif)
   - Isi motivasi/tujuan magang (textarea)
   - Upload dokumen: KTM + surat permohonan (file upload, store di storage/app/documents)
   - Submit → status = 'submitted'

2. Halaman status pengajuan: 
   - Timeline status (draft → submitted → approved/rejected)
   - Jika rejected: tampilkan rejection_reason
   - Jika approved: tombol download surat pengantar PDF

ADMIN:
3. List semua pengajuan (InternshipApplicationController@index untuk admin):
   - Tabel dengan filter: status, periode, perusahaan
   - Badge warna per status
   - Tombol: Review Detail

4. Detail pengajuan:
   - Info mahasiswa + perusahaan + dokumen yang diupload
   - Form approve: assign dosen pembimbing + set tanggal mulai & selesai
   - Form reject: input alasan penolakan

5. Generate surat pengantar PDF:
   - Blade template surat resmi: resources/views/pdf/surat-pengantar.blade.php
   - Data: nama mahasiswa, NIM, perusahaan, periode, tanggal
   - Route: GET /admin/applications/{id}/surat-pdf
   - Simpan ke storage + update documents table

All views use layouts.app and DESIGN.md styling.
```

---

## Fase 3 — Logbook Digital

**Tujuan:** Mahasiswa isi logbook harian, dosen review dan approve per minggu.

**Depends on:** Fase 2 selesai (butuh internship_application yang approved)

**Deliverable yang bisa ditest:**
- Mahasiswa isi kegiatan harian → submit
- Dosen lihat logbook mahasiswa bimbingan → approve/beri catatan
- Mahasiswa lihat feedback dosen di logbooknya

### Checklist
- [x] Form input logbook harian (mahasiswa)
- [x] List logbook dengan filter tanggal/minggu
- [x] Status logbook per entry (draft/submitted/approved/rejected)
- [x] Dosen: list mahasiswa bimbingan + logbook pending
- [x] Dosen: review logbook — approve atau reject dengan catatan
- [x] Notifikasi sederhana ketika logbook di-review

### Prompt Antigravity
```
[CONSTRAINTS]

Phase 3: Logbook Digital.

MAHASISWA:
1. List logbook (LogbookController@index):
   - Filter: minggu ini / bulan ini / semua
   - Badge status per entry: draft (abu), submitted (biru), 
     approved (hijau), rejected (merah)
   - Tombol: Tambah Logbook Hari Ini, Edit (jika draft/rejected)

2. Form logbook (LogbookController@create):
   - Date picker (default: hari ini, tidak bisa pilih masa depan)
   - Textarea: Kegiatan yang dilakukan (required)
   - Textarea: Pembelajaran/insight (optional)
   - Tombol: Simpan Draft | Submit ke Dosen

3. Edit logbook — hanya bisa jika status draft atau rejected

DOSEN:
4. Halaman mahasiswa bimbingan:
   - List mahasiswa dengan badge: ada logbook pending / tidak ada
   - Klik mahasiswa → lihat semua logbook mahasiswa tersebut

5. Review logbook:
   - Tampilkan isi logbook lengkap
   - Tombol: Approve | Reject
   - Jika reject: wajib isi catatan (supervisor_note)
   - Update status + reviewed_at

All views use layouts.app and DESIGN.md styling.
```

---

## Fase 4 — QR Code Presensi

**Tujuan:** Mahasiswa generate QR unik harian, perusahaan scan untuk verifikasi kehadiran.

**Depends on:** Fase 2 selesai

**Deliverable yang bisa ditest:**
- Mahasiswa generate QR → tampil di layar
- Perusahaan input/scan QR → status hadir tercatat
- Rekap kehadiran mahasiswa bisa dilihat

### Checklist
- [x] Install simplesoftwareio/simple-qrcode
- [x] Generate QR unik per mahasiswa per hari
- [x] Halaman presensi mahasiswa (tampilkan QR + riwayat)
- [x] Halaman verifikasi QR (perusahaan)
- [x] Rekap kehadiran (admin + mahasiswa)

### Prompt Antigravity
```
[CONSTRAINTS]

Phase 4: QR Code Presensi.

Install QR library:
composer require simplesoftwareio/simple-qrcode

1. Generate QR harian (AttendanceController@generateQr):
   - Cek apakah sudah ada attendance record untuk hari ini
   - Jika belum: buat record baru dengan qr_token = UUID unik
   - Generate QR code dari qr_token
   - Tampilkan QR di halaman mahasiswa dengan tanggal + instruksi
   - QR hanya valid untuk hari itu (validasi tanggal saat scan)

2. Halaman presensi mahasiswa:
   - QR besar di tengah untuk hari ini
   - Tabel riwayat: tanggal, check_in, check_out, status verifikasi
   - Badge: Hadir / Belum Diverifikasi / Tidak Hadir

3. Verifikasi QR (perusahaan):
   - Input field: paste QR token atau scan
   - Tombol: Verifikasi Kehadiran
   - Jika valid: update verified_by + verified_at, tampilkan info mahasiswa
   - Jika invalid/expired: tampilkan pesan error
   - List presensi hari ini yang sudah diverifikasi

4. Rekap kehadiran (admin):
   - Filter: mahasiswa, periode, bulan
   - Tabel: tanggal, check_in, check_out, diverifikasi oleh

All views use layouts.app and DESIGN.md styling.
```

---

## Fase 5 — Penilaian

**Tujuan:** Dosen dan perusahaan input nilai per aspek, mahasiswa lihat rekap nilai.

**Depends on:** Fase 3 selesai

**Deliverable yang bisa ditest:**
- Dosen input nilai 5 aspek untuk mahasiswa bimbingan
- Perusahaan input nilai 5 aspek untuk mahasiswa magang
- Mahasiswa lihat nilai dari dosen + perusahaan + rata-rata

### Checklist
- [x] Form penilaian dosen (5 aspek, 0–100)
- [x] Form penilaian perusahaan (5 aspek, 0–100)
- [x] Kalkulasi nilai akhir otomatis (on-the-fly, tidak disimpan ke DB)
- [x] Halaman nilai mahasiswa

### Prompt Antigravity
```
[CONSTRAINTS]

Phase 5: Penilaian.

Aspek penilaian (0–100 per aspek):
- Kedisiplinan (discipline)
- Sikap & Perilaku (attitude)
- Kemampuan Teknis (skills)
- Komunikasi (communication)
- Inisiatif (initiative)
- Final score = rata-rata kelima aspek

DOSEN:
1. Form input nilai (AssessmentController@store):
   - Pilih mahasiswa bimbingan (yang sudah approved)
   - 5 slider/input angka per aspek (0–100)
   - Textarea: catatan penilaian
   - Submit → assessor_type = 'dosen'
   - Hanya bisa input 1x per mahasiswa per application

PERUSAHAAN:
2. Form penilaian mahasiswa:
   - List mahasiswa magang di perusahaan ini
   - Form sama: 5 aspek + catatan
   - Submit → assessor_type = 'perusahaan'

MAHASISWA:
3. Halaman status penilaian:
   - Card nilai dari Dosen: per aspek + rata-rata (jika sudah dinilai)
   - Card nilai dari Perusahaan: per aspek + rata-rata (jika sudah dinilai)
   - Card nilai akhir: rata-rata dari kedua penilai
   - Badge status: Menunggu Penilaian / Sudah Dinilai

All views use layouts.app and DESIGN.md styling.
```

---

## Fase 6 — Notifikasi + Export Laporan

**Tujuan:** Sistem notifikasi berjalan otomatis, admin bisa export data ke Excel/PDF.

**Depends on:** Fase 5 selesai

### Checklist
- [x] Install maatwebsite/excel
- [x] In-app notification (database driver)
- [x] Export kehadiran ke Excel
- [x] Export rekap nilai ke Excel
- [x] Export laporan PDF per mahasiswa
- [x] Sertifikat magang PDF (download mahasiswa)

> **Catatan:** Email notification (queue-based) di-skip untuk MVP. Database driver saja.

### Prompt Antigravity
```
[CONSTRAINTS]

Phase 6: Notifikasi + Export Laporan.

Install packages:
composer require maatwebsite/excel

NOTIFIKASI:
1. Setup Laravel Notifications dengan database driver.
   Buat notifikasi untuk event:
   - Pengajuan diapprove/reject (→ mahasiswa)
   - Logbook di-review (→ mahasiswa)
   - Ada logbook baru pending review (→ dosen)
   - Nilai sudah diinput (→ mahasiswa)

2. Bell notifikasi di header (layouts/app.blade.php):
   - Badge angka notifikasi belum dibaca
   - Dropdown: list 5 notifikasi terbaru
   - Link: Lihat semua notifikasi
   - Mark as read saat diklik

3. Halaman notifikasi lengkap (semua role)

EXPORT:
4. Admin: Export rekap kehadiran (Excel):
   - Filter: periode, mahasiswa, rentang tanggal
   - Kolom: Nama, NIM, Perusahaan, Total Hadir, Total Tidak Hadir

5. Admin: Export rekap nilai (Excel):
   - Kolom: Nama, NIM, Perusahaan, Dosen, 
     Nilai Dosen, Nilai Perusahaan, Nilai Akhir

6. Admin: Laporan magang PDF (per mahasiswa):
   - Ringkasan: data mahasiswa, perusahaan, periode
   - Rekap kehadiran
   - Rekap logbook
   - Nilai akhir

All views use layouts.app and DESIGN.md styling.
```

---

## Referensi Cepat

### Package yang Digunakan
| Package | Kegunaan | Install |
|---|---|---|
| spatie/laravel-permission | Role & permission | `composer require spatie/laravel-permission` |
| barryvdh/laravel-dompdf | Generate PDF | `composer require barryvdh/laravel-dompdf` |
| simplesoftwareio/simple-qrcode | QR Code | `composer require simplesoftwareio/simple-qrcode` |
| maatwebsite/excel | Export Excel | `composer require maatwebsite/excel` |

### Akun Test
| Email | Password | Role |
|---|---|---|
| admin@simagang.test | password | Admin Prodi |
| dosen@simagang.test | password | Dosen Pembimbing |
| mhs1@simagang.test | password | Mahasiswa |
| mhs2@simagang.test | password | Mahasiswa |
| company@simagang.test | password | Perusahaan Mitra |

### Perintah yang Sering Dipakai
```bash
php artisan migrate:fresh --seed   # Reset DB + seed ulang
php artisan db:seed                # Seed tanpa reset
php artisan serve                  # Jalankan server (port 8000)
npm run dev                        # Compile assets (tetap jalan)
php artisan make:controller NamaController --resource
php artisan make:model NamaModel -m
php artisan make:notification NamaNotification
php artisan make:export NamaExport --model=NamaModel
```
