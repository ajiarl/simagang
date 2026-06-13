@extends('layouts.app')

@section('title', 'Dashboard Dosen Pembimbing')
@section('page-title', 'Dashboard')

@section('content')
{{-- Welcome Banner --}}
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body">
        <h2 class="text-display-lg" style="color: #191c20; margin-bottom: 4px;">
            Selamat datang, {{ auth()->user()->name }}
        </h2>
        <p class="text-body-md" style="color: #424751;">
            {{ auth()->user()->faculty ?? 'Fakultas' }} — Dosen Pembimbing Magang
        </p>
    </div>
</div>

{{-- Stats Grid --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 24px;">
    {{-- Mahasiswa Bimbingan --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #d6e3ff; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #003e7e; font-size: 20px;">groups</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Mahasiswa Bimbingan</span>
            </div>
            @php
                $studentCount = auth()->user()->supervisedApplications()->where('status', 'approved')->count();
            @endphp
            <p class="text-headline-md" style="color: #191c20;">{{ $studentCount }} mahasiswa</p>
        </div>
    </div>

    {{-- Logbook Pending --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fef08a; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #854d0e; font-size: 20px;">pending_actions</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Logbook Pending</span>
            </div>
            @php
                $pendingLogbooks = \App\Models\Logbook::where('status', 'submitted')
                    ->whereHas('internshipApplication', fn($q) => $q->where('dosen_id', auth()->id()))
                    ->count();
            @endphp
            <p class="text-headline-md" style="color: #191c20;">{{ $pendingLogbooks }}</p>
            @if($pendingLogbooks > 0)
                <span class="chip-pending" style="margin-top: 8px;">Perlu direview</span>
            @endif
        </div>
    </div>

    {{-- Reviews Selesai --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #dcfce7; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #166534; font-size: 20px;">fact_check</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Reviews Selesai</span>
            </div>
            @php
                $reviewsDone = \App\Models\Logbook::whereIn('status', ['approved', 'rejected'])
                    ->where('reviewed_by', auth()->id())
                    ->count();
            @endphp
            <p class="text-headline-md" style="color: #191c20;">{{ $reviewsDone }}</p>
        </div>
    </div>

    {{-- Belum Dinilai --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #ffdcc6; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #673000; font-size: 20px;">grade</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Belum Dinilai</span>
            </div>
            @php
                $assessed = auth()->user()->assessmentsGiven()->pluck('internship_application_id')->toArray();
                $needAssessment = auth()->user()->supervisedApplications()
                    ->where('status', 'approved')
                    ->whereNotIn('id', $assessed)
                    ->count();
            @endphp
            <p class="text-headline-md" style="color: #191c20;">{{ $needAssessment }} mahasiswa</p>
        </div>
    </div>
</div>

{{-- Two Column Layout --}}
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    {{-- Pending Reviews --}}
    <div class="card">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between;">
            <h3 class="text-headline-sm" style="color: #191c20;">Logbook Perlu Review</h3>
            <a href="{{ route('dosen.students.index') }}" class="text-label-md" style="color: #0058be; text-decoration: none;">Lihat Semua →</a>
        </div>
        <div style="padding: 20px;">
            @php
                $recentLogbooks = \App\Models\Logbook::where('status', 'submitted')
                    ->whereHas('internshipApplication', fn($q) => $q->where('dosen_id', auth()->id()))
                    ->with('user')
                    ->latest('date')
                    ->limit(5)
                    ->get();
            @endphp
            @if($recentLogbooks->isEmpty())
                <p class="text-body-sm" style="color: #737782; text-align: center; padding: 32px 0;">
                    Tidak ada logbook yang perlu direview.
                </p>
            @else
                @foreach($recentLogbooks as $log)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; {{ !$loop->last ? 'border-bottom: 1px solid #e2e2e9;' : '' }}">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="avatar" style="width: 36px; height: 36px; font-size: 12px;">{{ $log->user->initials }}</div>
                        <div>
                            <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $log->user->name }}</p>
                            <p class="text-label-sm" style="color: #737782;">{{ $log->date->format('d M Y') }}</p>
                        </div>
                    </div>
                    <span class="chip-pending">Menunggu</span>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Daftar Mahasiswa --}}
    <div class="card">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
            <h3 class="text-headline-sm" style="color: #191c20;">Mahasiswa Bimbingan</h3>
        </div>
        <div style="padding: 20px;">
            @php
                $students = auth()->user()->supervisedApplications()
                    ->where('status', 'approved')
                    ->with('user')
                    ->get();
            @endphp
            @if($students->isEmpty())
                <p class="text-body-sm" style="color: #737782; text-align: center; padding: 16px 0;">
                    Belum ada mahasiswa bimbingan.
                </p>
            @else
                @foreach($students as $app)
                <div style="display: flex; align-items: center; gap: 12px; padding: 10px 0; {{ !$loop->last ? 'border-bottom: 1px solid #e2e2e9;' : '' }}">
                    <div class="avatar" style="width: 36px; height: 36px; font-size: 12px;">{{ $app->user->initials }}</div>
                    <div style="flex: 1;">
                        <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $app->user->name }}</p>
                        <p class="text-label-sm" style="color: #737782;">{{ $app->user->nim ?? 'NIM' }}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<style>
    @media (max-width: 1023px) {
        div[style*="grid-template-columns: repeat(4"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        div[style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
