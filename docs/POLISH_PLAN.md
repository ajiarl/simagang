# POLISH_PLAN.md — SiMagang Gaps & Refactoring Plan

Berdasarkan hasil audit kode yang dilakukan, dokumen ini merinci fitur-fitur yang masih kurang atau perlu diperbaiki untuk memenuhi spesifikasi di `PRD_SiMagang_v1.md`. Semua item di bawah telah diselesaikan pada fase akhir MVP.

## Priority 1: Dead Sidebar Links (Fitur yang Belum Ada) — ✅ Selesai

Semua fitur berikut telah diimplementasi dengan controller, view, dan route yang lengkap.

1. ✅ **Admin: Manajemen Mahasiswa**
   - `app/Http/Controllers/Admin/StudentController.php` — index, show, edit, update
   - `resources/views/admin/students/` — index & edit views
   - Route: `admin.students.{index,show,edit,update}` via `resource()` di `routes/admin.php`
   - Admin dapat melihat daftar seluruh mahasiswa, detail profil, dan mengubah data.

2. ✅ **Admin: Manajemen Perusahaan Mitra**
   - `app/Http/Controllers/Admin/CompanyController.php` — full CRUD
   - `resources/views/admin/companies/` — index, create, edit, show views
   - Route: `admin.companies.*` (resource) di `routes/admin.php`

3. ✅ **Admin: Manajemen Periode Magang**
   - `app/Http/Controllers/Admin/PeriodController.php` — index, create, store, edit, update
   - `resources/views/admin/periods/` — index, create, edit views
   - Route: `admin.periods.*` di `routes/admin.php`

4. ✅ **Admin: Halaman Laporan (Report Index)**
   - Method `index` ditambahkan ke `app/Http/Controllers/Admin/ReportController.php`
   - `resources/views/admin/reports/index.blade.php` — UI dengan filter + tombol unduh
   - Route: `admin.reports.index`

5. ✅ **Dosen: Mahasiswa Bimbingan**
   - `app/Http/Controllers/Dosen/StudentController.php` — index, show
   - `resources/views/dosen/students/` — index & show views
   - Route: `dosen.students.index`, `dosen.students.show`

6. ✅ **Mahasiswa: Manajemen Dokumen**
   - `app/Http/Controllers/Mahasiswa/DocumentController.php` — index, download, downloadSurat, downloadSertifikat
   - `resources/views/mahasiswa/documents/index.blade.php`
   - Route: `mahasiswa.documents.*`
   - Termasuk: download surat pengantar PDF dan sertifikat magang PDF

---

## Priority 2: Dynamic Dashboard Data — ✅ Selesai

1. ✅ **Mahasiswa Dashboard**
   - `DashboardController::mahasiswa()` menghitung data dinamis dari DB:
     - Hari magang (dihitung dari `start_date` s/d hari ini)
     - Jumlah logbook approved
     - Persentase kehadiran dari tabel `attendances`
     - Status pengajuan aktif
   - `resources/views/mahasiswa/dashboard.blade.php` — semua stat cards dinamis

---

## Priority 3: Security & Code Refactoring — ✅ Selesai (Sebagian)

1. ✅ **Kebijakan Akses (Policies)**
   - `app/Policies/InternshipApplicationPolicy.php` — terdaftar via `Gate::policy()`
   - `app/Policies/AttendancePolicy.php` — terdaftar via `Gate::policy()`
   - `app/Policies/LogbookPolicy.php` — digunakan via auto-discovery Laravel
   - `app/Policies/AssessmentPolicy.php` — digunakan via auto-discovery Laravel

2. ⏭️ **Pemisahan Controller InternshipApplication** — Di-skip untuk MVP
   - `InternshipApplicationController` tetap satu file, dilindungi middleware `role:mahasiswa` dan `role:admin` di masing-masing route group.
   - Keputusan: middleware sudah cukup untuk MVP; split dijadwalkan untuk v2.

---

## Catatan Akhir MVP

- Semua 68 routes terdaftar dan berfungsi
- Tidak ada dead link `href="#"` di sidebar maupun dashboard
- Tidak ada stub method atau `// TODO` di controller
- PDF: `resources/views/pdf/surat-pengantar.blade.php` + `resources/views/pdf/sertifikat.blade.php`
- Sertifikat hanya bisa diunduh jika `status === 'completed'`
