# Penjelasan Flow Aplikasi SiMagang
> **Sistem Informasi Magang Mahasiswa**  
> Dibuat untuk presentasi ke Dosen Pembimbing

---

## 1. Gambaran Umum Sistem

SiMagang adalah **sistem informasi berbasis web** yang mengelola **seluruh siklus magang mahasiswa** — dari pengajuan hingga penilaian akhir. Sistem ini menggantikan proses manual (surat fisik, logbook kertas, koordinasi via WhatsApp) menjadi digital dan terpusat.

### Masalah yang Diselesaikan
- ❌ Administrasi magang masih **manual** (surat fisik, logbook kertas)
- ❌ **Tidak ada transparansi** status pengajuan bagi mahasiswa
- ❌ Dosen **kewalahan** memantau banyak mahasiswa tanpa dashboard terpusat
- ❌ Perusahaan tidak punya cara mudah untuk **verifikasi kehadiran**

### Solusi SiMagang
- ✅ Semua proses **digital** dan terintegrasi dalam satu platform
- ✅ **4 role** dengan dashboard dan akses berbeda
- ✅ **Notifikasi otomatis** via in-app dan email
- ✅ **QR Code** untuk presensi harian
- ✅ **Export** laporan ke Excel dan PDF

---

## 2. Arsitektur Sistem

```mermaid
graph TD
    A[Browser / User] -->|HTTP Request| B[Laravel Router]
    B -->|Middleware Auth + Role| C{Role?}
    C -->|mahasiswa| D[Mahasiswa Controllers]
    C -->|dosen| E[Dosen Controllers]
    C -->|admin| F[Admin Controllers]
    C -->|perusahaan| G[Perusahaan Controllers]
    D --> H[Blade Views]
    E --> H
    F --> H
    G --> H
    D --> I[(MySQL Database)]
    E --> I
    F --> I
    G --> I
    H -->|HTML Response| A
```

### Tech Stack

| Komponen | Teknologi |
|---|---|
| **Framework** | Laravel 13 (PHP 8.3) |
| **Database** | MySQL |
| **Frontend** | Blade Template + Tailwind CSS v4 |
| **Autentikasi** | Laravel Auth + Spatie Permission (multi-role) |
| **PDF Generator** | DomPDF (surat pengantar + sertifikat) |
| **Excel Export** | Maatwebsite Excel |
| **QR Code** | SimpleSoftwareIO QR Code |
| **Email** | Gmail SMTP |
| **Hosting** | Railway (Docker-based) |

---

## 3. Database Schema (Entity Relationship)

```mermaid
erDiagram
    USERS ||--o{ INTERNSHIP_APPLICATIONS : "mengajukan (mahasiswa)"
    USERS ||--o{ LOGBOOKS : "mengisi"
    USERS ||--o{ ATTENDANCES : "presensi"
    USERS ||--o{ ASSESSMENTS : "dinilai (dosen)"
    COMPANIES ||--o{ INTERNSHIP_APPLICATIONS : "menerima"
    COMPANIES ||--o{ ASSESSMENTS : "menilai (perusahaan)"
    INTERNSHIP_PERIODS ||--o{ INTERNSHIP_APPLICATIONS : "periode"
    INTERNSHIP_APPLICATIONS ||--o{ DOCUMENTS : "lampiran"
    INTERNSHIP_APPLICATIONS ||--o{ LOGBOOKS : "logbook harian"
    INTERNSHIP_APPLICATIONS ||--o{ ATTENDANCES : "rekap hadir"

    USERS {
        int id PK
        string name
        string email
        string nim
        string role "mahasiswa/dosen/admin/perusahaan"
    }

    COMPANIES {
        int id PK
        string name
        string industry
        string contact_person
    }

    INTERNSHIP_PERIODS {
        int id PK
        string name
        date start_date
        date end_date
        boolean is_active
    }

    INTERNSHIP_APPLICATIONS {
        int id PK
        int user_id FK
        int company_id FK
        int internship_period_id FK
        int dosen_id FK
        string status "pending/approved/rejected"
        date start_date
        date end_date
    }

    DOCUMENTS {
        int id PK
        int application_id FK
        string type "ktm/surat/cv"
        string file_path
    }

    LOGBOOKS {
        int id PK
        int application_id FK
        int user_id FK
        date date
        text activity
        string status "draft/submitted/approved/rejected"
        text supervisor_note
    }

    ATTENDANCES {
        int id PK
        int user_id FK
        int application_id FK
        date date
        string qr_token
        timestamp verified_at
    }

    ASSESSMENTS {
        int id PK
        int application_id FK
        int assessor_id FK
        string assessor_type "dosen/perusahaan"
        int score_1
        int score_2
        int score_3
    }
```

---

## 4. Flow Per Role

### 4.1 Flow Mahasiswa

```mermaid
flowchart TD
    A[Login] --> B[Dashboard Mahasiswa]
    B --> C{Sudah punya pengajuan?}
    C -->|Belum| D[Buat Pengajuan Magang]
    D --> D1[Pilih Perusahaan & Periode]
    D1 --> D2[Upload Dokumen: KTM, Surat, CV]
    D2 --> D3[Submit Pengajuan]
    D3 --> D4[Status: Menunggu]
    D4 --> D5{Admin Proses}
    D5 -->|Ditolak| D6[Notifikasi Ditolak + Alasan]
    D5 -->|Disetujui| E[Notifikasi Disetujui]
    
    C -->|Sudah disetujui| F[Magang Aktif]
    E --> F
    
    F --> G[Isi Logbook Harian]
    G --> G1[Tulis Kegiatan Hari Ini]
    G1 --> G2[Submit ke Dosen]
    G2 --> G3{Dosen Review}
    G3 -->|Revisi| G4[Perbaiki & Submit Ulang]
    G4 --> G2
    G3 -->|Disetujui| G5[✅ Logbook Approved]
    
    F --> H[Generate QR Presensi]
    H --> H1[Tunjukkan QR ke Perusahaan]
    H1 --> H2[Perusahaan Scan/Verifikasi]
    H2 --> H3[✅ Kehadiran Tercatat]
    
    F --> I[Upload Dokumen Tambahan]
    F --> J[Lihat Nilai Akhir]
    J --> J1[Nilai Dosen + Nilai Perusahaan]
```

**Penjelasan detail:**

1. **Login** → Mahasiswa login dengan email & password
2. **Dashboard** → Melihat ringkasan: status pengajuan, progress logbook, persentase kehadiran, nilai
3. **Pengajuan Magang** → Mengisi form (pilih perusahaan, periode, tulis motivasi) lalu upload 3 dokumen (KTM, surat permohonan, CV)
4. **Menunggu Persetujuan** → Admin akan review dan menyetujui/menolak
5. **Jika Disetujui** → Mahasiswa bisa mulai:
   - **Isi Logbook Harian**: Catat kegiatan setiap hari, submit ke dosen untuk review
   - **QR Presensi**: Generate QR code unik setiap hari, ditunjukkan ke perusahaan untuk verifikasi kehadiran
   - **Upload Dokumen**: Upload dokumen tambahan yang diperlukan
6. **Nilai Akhir** → Lihat nilai gabungan dari dosen pembimbing dan perusahaan

---

## 4.2 Flow Dosen Pembimbing

```mermaid
flowchart TD
    A[Login] --> B[Dashboard Dosen]
    B --> B1[Lihat Daftar Mahasiswa Bimbingan]
    B --> B2[Lihat Logbook Menunggu Review]
    
    B2 --> C[Klik Logbook Entry]
    C --> D[Baca Kegiatan Mahasiswa]
    D --> E{Keputusan}
    E -->|Setujui| F[✅ Approve + Notif ke Mahasiswa]
    E -->|Revisi| G[Tulis Catatan Revisi]
    G --> H[❌ Reject + Notif ke Mahasiswa]
    
    B1 --> I[Klik Mahasiswa]
    I --> J[Lihat Detail Progress]
    J --> K[Lihat Semua Logbook]
    J --> L[Lihat Rekap Kehadiran]
    
    B --> M[Isi Penilaian Akhir]
    M --> M1[Isi Skor Per Aspek]
    M1 --> M2[Submit Nilai]
    M2 --> M3[✅ Notif ke Mahasiswa]
```

**Penjelasan detail:**

1. **Dashboard** → Melihat ringkasan: jumlah mahasiswa bimbingan, logbook yang menunggu review
2. **Review Logbook** → Membaca kegiatan harian mahasiswa, lalu menyetujui atau meminta revisi (dengan catatan)
3. **Monitoring** → Melihat progress keseluruhan setiap mahasiswa bimbingan
4. **Penilaian** → Di akhir periode, mengisi form penilaian per aspek (skor 1-100)

---

## 4.3 Flow Admin Prodi

```mermaid
flowchart TD
    A[Login] --> B[Dashboard Admin]
    B --> B1[Statistik: Total Mahasiswa, Aktif Magang, Perusahaan Mitra]
    
    B --> C[Kelola Pengajuan Magang]
    C --> C1[Lihat Daftar Pengajuan]
    C1 --> C2[Klik Detail Pengajuan]
    C2 --> C3[Lihat Dokumen Mahasiswa]
    C3 --> C4{Keputusan}
    C4 -->|Setujui| C5[Assign Dosen Pembimbing]
    C5 --> C6[✅ Approve + Notif]
    C4 -->|Tolak| C7[Tulis Alasan Penolakan]
    C7 --> C8[❌ Reject + Notif]
    
    C6 --> D[Generate Surat Pengantar PDF]
    
    B --> E[Kelola Data Master]
    E --> E1[CRUD Mahasiswa]
    E --> E2[CRUD Perusahaan Mitra]
    E --> E3[CRUD Periode Magang]
    
    B --> F[Rekap & Laporan]
    F --> F1[Rekap Kehadiran]
    F --> F2[Export Excel: Kehadiran]
    F --> F3[Export Excel: Penilaian]
    F --> F4[Download PDF Laporan]
```

**Penjelasan detail:**

1. **Dashboard** → Statistik keseluruhan: total mahasiswa, mahasiswa aktif magang, jumlah perusahaan mitra, pengajuan pending
2. **Proses Pengajuan** → Review pengajuan mahasiswa, lihat dokumen lampiran, setujui/tolak, assign dosen pembimbing
3. **Generate Surat PDF** → Otomatis generate surat pengantar magang dalam format PDF
4. **Manajemen Data** → CRUD data mahasiswa, perusahaan mitra, dan periode magang
5. **Laporan** → Rekap kehadiran, export data ke Excel/PDF

---

## 4.4 Flow Perusahaan Mitra

```mermaid
flowchart TD
    A[Login] --> B[Dashboard Perusahaan]
    B --> B1[Lihat Daftar Mahasiswa Magang Aktif]
    
    B --> C[Verifikasi Presensi]
    C --> C1[Buka Scanner QR]
    C1 --> C2[Input/Scan Token QR Mahasiswa]
    C2 --> C3{Valid?}
    C3 -->|Ya| C4[✅ Kehadiran Tercatat]
    C3 -->|Tidak/Expired| C5[❌ QR Tidak Valid]
    
    B --> D[Penilaian Mahasiswa]
    D --> D1[Pilih Mahasiswa]
    D1 --> D2[Isi Form Penilaian Per Aspek]
    D2 --> D3[Submit Nilai]
    D3 --> D4[✅ Notif ke Mahasiswa]
```

**Penjelasan detail:**

1. **Dashboard** → Melihat daftar mahasiswa yang sedang magang di perusahaan tersebut
2. **Verifikasi Presensi** → Scan/input QR code yang ditunjukkan mahasiswa setiap hari. QR hanya valid untuk hari itu (expired keesokan harinya)
3. **Penilaian** → Di akhir periode magang, mengisi form penilaian dari perspektif industri

---

## 5. Flow Keseluruhan (End-to-End)

```mermaid
flowchart LR
    subgraph PENGAJUAN["1️⃣ Fase Pengajuan"]
        M1[Mahasiswa Isi Form] --> M2[Upload Dokumen]
        M2 --> A1[Admin Review]
        A1 -->|Approve| A2[Assign Dosen]
        A1 -->|Reject| A3[Notif Ditolak]
        A2 --> A4[Generate Surat PDF]
    end
    
    subgraph PELAKSANAAN["2️⃣ Fase Pelaksanaan Magang"]
        L1[Mahasiswa Isi Logbook Harian]
        L1 --> D1[Dosen Review Logbook]
        Q1[Mahasiswa Generate QR]
        Q1 --> P1[Perusahaan Verifikasi]
    end
    
    subgraph PENILAIAN["3️⃣ Fase Penilaian"]
        N1[Dosen Isi Nilai]
        N2[Perusahaan Isi Nilai]
        N1 --> N3[Nilai Akhir Gabungan]
        N2 --> N3
        N3 --> R1[Admin Export Laporan]
    end
    
    PENGAJUAN --> PELAKSANAAN
    PELAKSANAAN --> PENILAIAN
```

### Tiga Fase Utama:

| Fase | Aktor Utama | Aktivitas |
|---|---|---|
| **1. Pengajuan** | Mahasiswa → Admin | Mahasiswa submit form + dokumen, Admin review & approve/reject, Generate surat pengantar |
| **2. Pelaksanaan** | Mahasiswa ↔ Dosen ↔ Perusahaan | Logbook harian (mahasiswa ↔ dosen), Presensi QR (mahasiswa ↔ perusahaan) |
| **3. Penilaian** | Dosen + Perusahaan → Admin | Dosen & perusahaan input nilai, Admin export laporan keseluruhan |

---

## 6. Sistem Notifikasi

| Event | Siapa Dapat Notif | Channel |
|---|---|---|
| Pengajuan di-approve/reject | Mahasiswa | Database + Email |
| Logbook baru di-submit | Dosen Pembimbing | Database + Email |
| Logbook di-review (approve/revisi) | Mahasiswa | Database + Email |
| Penilaian selesai diisi | Mahasiswa | Database + Email |

---

## 7. Sistem Autentikasi & Otorisasi

```mermaid
flowchart TD
    A[User Akses URL] --> B{Sudah Login?}
    B -->|Belum| C[Redirect ke /login]
    B -->|Sudah| D{Cek Role via Middleware}
    D -->|Role cocok| E[Akses Halaman]
    D -->|Role tidak cocok| F[403 Forbidden]
    
    C --> G[Input Email + Password]
    G --> H{Valid?}
    H -->|Ya| I[Redirect ke Dashboard sesuai Role]
    H -->|Tidak| J[Error: Kredensial salah]
    
    I --> K{Role apa?}
    K -->|mahasiswa| L[/mahasiswa/dashboard]
    K -->|dosen| M[/dosen/dashboard]
    K -->|admin| N[/admin/dashboard]
    K -->|perusahaan| O[/perusahaan/dashboard]
```

- **Multi-role** menggunakan package **Spatie Laravel Permission**
- Setiap route group dilindungi **middleware `role:`** sehingga mahasiswa tidak bisa akses halaman admin, dan sebaliknya
- Tersedia fitur **Lupa Password** yang mengirim link reset via email

---

## 8. Deployment

| Aspek | Detail |
|---|---|
| **Live URL** | https://simagang-production.up.railway.app |
| **Hosting** | Railway (Docker-based, auto-deploy) |
| **Database** | MySQL (Railway managed service) |
| **Repository** | https://github.com/ajiarl/simagang |
| **CI/CD** | Push ke branch `main` → auto redeploy |

---

## 9. Ringkasan Fitur (8 Fitur MVP)

| No | Fitur | Deskripsi |
|---|---|---|
| 1 | **Multi-role Auth & Dashboard** | 4 role berbeda (mahasiswa, dosen, admin, perusahaan) dengan dashboard masing-masing |
| 2 | **Pengajuan Magang** | Form pengajuan + upload dokumen, approve/reject oleh admin |
| 3 | **Manajemen Dokumen & Surat** | Generate surat pengantar PDF otomatis, upload KTM/CV/surat |
| 4 | **Logbook Digital Harian** | Catat kegiatan harian, review & catatan dari dosen |
| 5 | **QR Code Presensi** | QR unik per hari, verifikasi oleh perusahaan |
| 6 | **Penilaian Terstruktur** | Nilai dari dosen & perusahaan, skor gabungan otomatis |
| 7 | **Notifikasi In-App & Email** | Notif otomatis untuk setiap perubahan status |
| 8 | **Laporan & Export** | Export data ke Excel (kehadiran, nilai) dan PDF |
