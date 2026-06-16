@extends('layouts.app')

@section('title', 'Laporan & Rekap')
@section('page-title', 'Laporan & Rekapitulasi')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 class="text-display-sm" style="color: #191c20; margin-bottom: 8px;">Laporan & Rekapitulasi</h2>
    <p class="text-body-sm" style="color: #424751;">Unduh rekapitulasi kehadiran, penilaian, dan laporan akhir mahasiswa magang.</p>
</div>

{{-- Filter Card --}}
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body">
        <form id="filterForm" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label class="form-label" for="period_select">Periode Magang</label>
                <select id="period_select" class="form-input" style="width: 100%;">
                    <option value="">Semua Periode</option>
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="flex: 1; min-width: 200px;">
                <label class="form-label" for="student_select">Mahasiswa</label>
                <select id="student_select" class="form-input" style="width: 100%;">
                    <option value="">Pilih Mahasiswa...</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->nim }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="button" onclick="applyFilters()" class="btn-primary" style="height: 40px; white-space: nowrap;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">filter_list</span> Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Export Cards Grid --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
    {{-- Kehadiran Card --}}
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
        <div class="card-body" style="flex-grow: 1;">
            <div style="width: 44px; height: 44px; border-radius: 8px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <span class="material-symbols-outlined" style="color: #003e7e; font-size: 24px;">event_available</span>
            </div>
            <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 8px;">Rekap Kehadiran</h3>
            <p class="text-body-sm" style="color: #424751; margin-bottom: 16px;">Unduh rekapitulasi data kehadiran harian seluruh mahasiswa magang dalam format Excel (.xlsx).</p>
        </div>
        <div style="padding: 0 16px 16px;">
            <a href="{{ route('admin.reports.attendances.export') }}" class="btn-secondary" style="width: 100%; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 40px; padding: 0;">
                <span class="material-symbols-outlined" style="font-size: 18px;">download</span> Unduh Excel
            </a>
        </div>
    </div>

    {{-- Nilai Card --}}
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
        <div class="card-body" style="flex-grow: 1;">
            <div style="width: 44px; height: 44px; border-radius: 8px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <span class="material-symbols-outlined" style="color: #003e7e; font-size: 24px;">grade</span>
            </div>
            <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 8px;">Rekap Nilai</h3>
            <p class="text-body-sm" style="color: #424751; margin-bottom: 16px;">Unduh rekapitulasi data penilaian dari dosen pembimbing dan mentor industri dalam format Excel (.xlsx).</p>
        </div>
        <div style="padding: 0 16px 16px;">
            <a href="{{ route('admin.reports.assessments.export') }}" class="btn-secondary" style="width: 100%; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 40px; padding: 0;">
                <span class="material-symbols-outlined" style="font-size: 18px;">download</span> Unduh Excel
            </a>
        </div>
    </div>

    {{-- PDF Laporan Card --}}
    <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
        <div class="card-body" style="flex-grow: 1;">
            <div style="width: 44px; height: 44px; border-radius: 8px; background: #ffdad6; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <span class="material-symbols-outlined" style="color: #ba1a1a; font-size: 24px;">picture_as_pdf</span>
            </div>
            <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 8px;">Laporan PDF Mahasiswa</h3>
            <p class="text-body-sm" style="color: #424751; margin-bottom: 16px;">Unduh dokumen laporan akhir individu mahasiswa secara lengkap (biodata, nilai, presensi, logbook) dalam format PDF.</p>
        </div>
        <div style="padding: 0 16px 16px;">
            <button type="button" onclick="downloadStudentPdf()" class="btn-primary" style="width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 40px; padding: 0; background: #ba1a1a; color: #ffffff; border: none;">
                <span class="material-symbols-outlined" style="font-size: 18px;">picture_as_pdf</span> Cetak PDF
            </button>
        </div>
    </div>
</div>

<script>
    function applyFilters() {
        const periodId = document.getElementById('period_select').value;
        const studentId = document.getElementById('student_select').value;
        
        let queryParams = new URLSearchParams(window.location.search);
        if (periodId) queryParams.set('period_id', periodId);
        else queryParams.delete('period_id');
        
        if (studentId) queryParams.set('user_id', studentId);
        else queryParams.delete('user_id');

        window.location.search = queryParams.toString();
    }

    function downloadStudentPdf() {
        const studentId = document.getElementById('student_select').value;
        if (!studentId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: 'Silakan pilih Mahasiswa terlebih dahulu pada dropdown filter.',
                confirmButtonColor: '#003e7e'
            });
            return;
        }

        const url = "{{ route('admin.reports.pdf') }}?user_id=" + studentId;
        window.open(url, '_blank');
    }

    // Restore selected values from URL query string
    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        if (params.has('period_id')) {
            document.getElementById('period_select').value = params.get('period_id');
        }
        if (params.has('user_id')) {
            document.getElementById('student_select').value = params.get('user_id');
        }
    });
</script>
@endsection
