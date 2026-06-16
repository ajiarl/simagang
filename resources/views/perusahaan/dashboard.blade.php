@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')
@section('page-title', 'Dashboard')

@section('content')
{{-- Welcome Banner --}}
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body">
        <h2 class="text-display-lg" style="color: #191c20; margin-bottom: 4px;">
            Selamat datang, {{ auth()->user()->name }}
        </h2>
        <p class="text-body-md" style="color: #424751;">
            {{ auth()->user()->company->name ?? 'Perusahaan Mitra' }} — Dashboard Perusahaan
        </p>
    </div>
</div>

{{-- Stats Grid --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 24px;">
    {{-- Mahasiswa Magang --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #d6e3ff; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #003e7e; font-size: 20px;">groups</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Mahasiswa Magang</span>
            </div>
            @php
                $companyId = auth()->user()->company_id;
                $activeStudents = $companyId
                    ? \App\Models\InternshipApplication::where('company_id', $companyId)
                        ->where('status', 'approved')
                        ->count()
                    : 0;
            @endphp
            <p class="text-headline-md" style="color: #191c20;">{{ $activeStudents }} mahasiswa</p>
        </div>
    </div>

    {{-- Presensi Hari Ini --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #dcfce7; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #166534; font-size: 20px;">event_available</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Presensi Hari Ini</span>
            </div>
            @php
                $todayAttendance = $companyId
                    ? \App\Models\Attendance::where('date', today())
                        ->where('status', 'verified')
                        ->whereHas('internshipApplication', fn($q) => $q->where('company_id', $companyId))
                        ->count()
                    : 0;
            @endphp
            <p class="text-headline-md" style="color: #191c20;">{{ $todayAttendance }} diverifikasi</p>
        </div>
    </div>

    {{-- Belum Dinilai --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fef08a; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #854d0e; font-size: 20px;">grade</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Perlu Dinilai</span>
            </div>
            @php
                $assessed = auth()->user()->assessmentsGiven()->pluck('internship_application_id')->toArray();
                $needAssess = $companyId
                    ? \App\Models\InternshipApplication::where('company_id', $companyId)
                        ->where('status', 'approved')
                        ->whereNotIn('id', $assessed)
                        ->count()
                    : 0;
            @endphp
            <p class="text-headline-md" style="color: #191c20;">{{ $needAssess }} mahasiswa</p>
        </div>
    </div>
</div>

{{-- Daftar Mahasiswa --}}
<div class="card">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between;">
        <h3 class="text-headline-sm" style="color: #191c20;">Mahasiswa Magang Aktif</h3>
    </div>
    <div style="padding: 20px;">
        @php
            $students = $companyId
                ? \App\Models\InternshipApplication::where('company_id', $companyId)
                    ->where('status', 'approved')
                    ->with('user')
                    ->get()
                : collect();
        @endphp
        @if($students->isEmpty())
            <p class="text-body-sm" style="color: #737782; text-align: center; padding: 32px 0;">
                Tidak ada mahasiswa magang aktif saat ini.
            </p>
        @else
            @foreach($students as $app)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 0; {{ !$loop->last ? 'border-bottom: 1px solid #e2e2e9;' : '' }}">
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <div class="avatar" style="width: 40px; height: 40px; font-size: 14px;">{{ $app->user->initials }}</div>
                    <div>
                        <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $app->user->name }}</p>
                        <p class="text-label-sm" style="color: #737782;">{{ $app->user->nim ?? 'NIM' }} · {{ $app->user->department ?? 'Prodi' }}</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    @php
                        $todayPresent = \App\Models\Attendance::where('user_id', $app->user_id)
                            ->where('date', today())
                            ->where('status', 'verified')
                            ->exists();
                    @endphp
                    @if($todayPresent)
                        <span class="chip-approved">Hadir</span>
                    @else
                        <span class="chip-pending" style="background: #ededf4; color: #424751;">Belum Presensi</span>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<style>
    @media (max-width: 1023px) {
        div[style*="grid-template-columns: repeat(3"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
