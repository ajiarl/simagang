# HANDOFF.md — Proyek SiMagang
> Baca dokumen ini sebelum melanjutkan di sesi atau akun baru.
> **Last updated:** 13 Juni 2026 — Final MVP

---

## 1. Status Proyek — MVP SELESAI ✅

Semua 23 screen dari PRD v1.0 sudah diimplementasi. 68 routes terdaftar. Tidak ada dead link, stub method, atau placeholder di sidebar.

### 8 Fitur MVP
| ID | Fitur | Status |
|---|---|---|
| F-01 | Multi-role auth & dashboard | ✅ Dinamis |
| F-02 | Pendaftaran & pengajuan magang | ✅ |
| F-03 | Manajemen surat & dokumen + sertifikat | ✅ |
| F-04 | Logbook digital harian | ✅ |
| F-05 | QR Code presensi | ✅ |
| F-06 | Penilaian terstruktur | ✅ |
| F-07 | Notifikasi in-app (database driver) | ✅ |
| F-08 | Laporan & ekspor Excel + PDF | ✅ |

---

## 2. Cara Menjalankan Lokal

```bash
cd "D:\0. MataKuliah\Semester 4\uass\simagang"

# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Buka: `http://localhost:8000`

### Reset data
```bash
php artisan migrate:fresh --seed
```

---

## 3. Akun Test

| Email | Password | Role |
|---|---|---|
| admin@simagang.test | password | Admin Prodi |
| dosen@simagang.test | password | Dosen Pembimbing |
| mhs1@simagang.test | password | Mahasiswa |
| mhs2@simagang.test | password | Mahasiswa |
| company@simagang.test | password | Perusahaan Mitra |

> `mhs1` perlu application approved untuk test logbook, presensi, dokumen.
> Buat via tinker kalau terhapus setelah migrate:fresh (lihat Section 12).

---

## 4. Database

**Nama:** `simagang` | **Host:** localhost:3306 | **User:** root

### Naming Penting (Berbeda dari Blueprint Awal)
| Blueprint | Aktual DB |
|---|---|
| `period_id` | `internship_period_id` |
| `supervisor_id` | `dosen_id` |
| `application()` | `internshipApplication()` |
| `period()` | `internshipPeriod()` |
| `student()` | `user()` |

### Kolom Aktual `internship_applications`
```
user_id, company_id, internship_period_id, dosen_id,
motivation, status, rejection_reason,
start_date, end_date, approved_at
```

---

## 5. Struktur Controller

```
app/Http/Controllers/
├── Auth/               LoginController
├── Admin/              StudentController, CompanyController, PeriodController,
│                       ReportController, AttendanceController
├── Dosen/              LogbookController, AssessmentController, StudentController
├── Mahasiswa/          LogbookController, AttendanceController, DocumentController,
│                       AssessmentController
├── Perusahaan/         AttendanceController, AssessmentController
├── DashboardController.php          (method: admin, dosen, mahasiswa, perusahaan)
├── ProfileController.php            (method: edit, update, updatePassword)
├── InternshipApplicationController.php  (method: indexAdmin, indexMahasiswa,
│                                         create, store, show, approve, reject, generatePdf)
└── NotificationController.php       (method: index, markAllAsRead)
```

---

## 6. Policies

| Policy | File | Registrasi |
|---|---|---|
| LogbookPolicy | `app/Policies/LogbookPolicy.php` | Auto-discovery (dipakai via `$this->authorize()`) |
| AssessmentPolicy | `app/Policies/AssessmentPolicy.php` | Auto-discovery |
| InternshipApplicationPolicy | `app/Policies/InternshipApplicationPolicy.php` | `Gate::policy()` di `AppServiceProvider::boot()` |
| AttendancePolicy | `app/Policies/AttendancePolicy.php` | `Gate::policy()` di `AppServiceProvider::boot()` |

Hanya `InternshipApplicationPolicy` dan `AttendancePolicy` yang didaftarkan eksplisit via `Gate::policy()`. `LogbookPolicy` dan `AssessmentPolicy` bekerja via auto-discovery Laravel.

---

## 7. Tech Stack & Package

| Package | Versi | Kegunaan |
|---|---|---|
| laravel/framework | ^13.8 | Framework utama |
| PHP | ^8.3 | Runtime |
| spatie/laravel-permission | ^8.0 | Role & permission |
| barryvdh/laravel-dompdf | ^3.1 | PDF surat pengantar + sertifikat |
| maatwebsite/excel | * | Export Excel |
| simplesoftwareio/simple-qrcode | ^4.2 | QR Code presensi |
| SweetAlert2 | CDN | Alert & konfirmasi UI |
| Alpine.js | CDN | Sidebar toggle & dropdown |

---

## 8. Design System

```
Primary          : #003e7e
Primary Container: #1A56A0
Background       : #F8FAFC
Surface          : #FFFFFF
Font             : Inter, 14–15px
Alert            : SweetAlert2 (session flash -> popup otomatis)
Validation error : <x-form-error name="field" /> component
PDF font         : DejaVu Sans (Unicode support)
```

File referensi: `docs/DESIGN.md`

---

## 9. Route Overview (68 routes total)

| Prefix | Count | Contoh Route Name |
|---|---|---|
| `/admin` | 28 | `admin.applications.index`, `admin.students.index`, `admin.companies.*`, `admin.periods.*`, `admin.reports.*`, `admin.attendances.index` |
| `/dosen` | 8 | `dosen.logbooks.*`, `dosen.assessments.*`, `dosen.students.*` |
| `/mahasiswa` | 13 | `mahasiswa.logbooks.*`, `mahasiswa.attendances.*`, `mahasiswa.documents.*`, `mahasiswa.assessments.index`, `mahasiswa.applications.*` |
| `/perusahaan` | 6 | `perusahaan.attendances.*`, `perusahaan.assessments.*` |
| Shared | 13 | `profile.*`, `notifications.*`, `dashboard`, `login`, `logout` |

---

## 10. Keputusan Teknis

| Topik | Keputusan |
|---|---|
| Email notifikasi | Skip MVP — database driver saja |
| Controller split InternshipApplication | Skip — middleware per role sudah cukup |
| Combined final score | Hitung on the fly, tidak disimpan ke DB |
| QR expiry | `whereDate('date', today())` di `verify()` |
| Stitch design screens | Skip — DESIGN.md sudah cukup sebagai referensi |

---

## 11. Yang Belum Dikerjakan (v2)

- Email notifications (Mailable + queue)
- Forgot password flow
- Download lampiran dokumen di admin/applications/show
- Export laporan massal semua mahasiswa sekaligus
- Split `InternshipApplicationController` per namespace role
- Deploy ke server/hosting
- Fitur v2: AI logbook, alumni network, skill matching, gamifikasi

---

## 12. File Dokumentasi

| File | Isi |
|---|---|
| `docs/DESIGN.md` | Design system dari Stitch |
| `docs/PRD_SiMagang_v1.md` | Product requirements |
| `docs/IMPLEMENTATION_PLAN.md` | Rencana implementasi per fase + prompt Antigravity |
| `docs/POLISH_PLAN.md` | Gap analysis — semua selesai |
| `docs/PHASE0_BLUEPRINT.md` | Blueprint arsitektur & schema (jika ada) |
| `README.md` | Cara install & jalankan (di root project) |

---

## 13. Tinker — Buat Application Approved untuk mhs1

Jalankan di `php artisan tinker` kalau data terhapus setelah migrate:fresh:

```php
$mhs1    = App\Models\User::where('email', 'mhs1@simagang.test')->first();
$company = App\Models\Company::first();
$period  = App\Models\InternshipPeriod::where('is_active', true)->first();
$dosen   = App\Models\User::where('email', 'dosen@simagang.test')->first();

App\Models\InternshipApplication::create([
    'user_id'              => $mhs1->id,
    'company_id'           => $company->id,
    'internship_period_id' => $period->id,
    'dosen_id'             => $dosen->id,
    'status'               => 'approved',
    'start_date'           => now(),
    'end_date'             => now()->addMonths(3),
]);
```