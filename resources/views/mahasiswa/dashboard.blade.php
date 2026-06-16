@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('page-title', 'Dashboard')

@section('content')
@if(!$stats['has_application'])
    {{-- Welcome Banner --}}
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <h2 class="text-display-lg" style="color: #191c20; margin-bottom: 4px;">
                    Selamat datang, {{ auth()->user()->name }}
                </h2>
                <p class="text-body-md" style="color: #424751;">
                    {{ auth()->user()->faculty ?? 'Fakultas' }} — {{ auth()->user()->department ?? 'Program Studi' }}
                </p>
            </div>
            <span class="chip-pending" style="padding: 6px 14px; font-size: 13px;">Belum Magang</span>
        </div>
    </div>

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body" style="text-align: center; padding: 40px 20px;">
            <div style="width: 64px; height: 64px; border-radius: 9999px; background: #ffdad6; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <span class="material-symbols-outlined" style="color: #ba1a1a; font-size: 32px;">info</span>
            </div>
            <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 8px;">Belum Ada Magang Aktif</h3>
            <p class="text-body-sm" style="color: #424751; max-width: 480px; margin: 0 auto 24px;">
                Belum ada magang aktif. Ajukan magang terlebih dahulu untuk memulai kegiatan magang Anda.
            </p>
            <a href="{{ route('mahasiswa.applications.index') }}" class="btn-primary" style="text-decoration: none;">
                Ajukan Magang
            </a>
        </div>
    </div>
@else
    {{-- Welcome Banner --}}
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <h2 class="text-display-lg" style="color: #191c20; margin-bottom: 4px;">
                    Selamat datang, {{ auth()->user()->name }}
                </h2>
                <p class="text-body-md" style="color: #424751;">
                    {{ auth()->user()->faculty ?? 'Fakultas' }} — {{ auth()->user()->department ?? 'Program Studi' }}
                </p>
            </div>
            @if(!$stats['logbook_hari_ini'])
                <span class="chip-pending" style="background: #ffdad6; color: #ba1a1a; padding: 6px 14px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">warning</span> Belum Isi Logbook Hari Ini
                </span>
            @else
                <span class="chip-approved" style="padding: 6px 14px; font-size: 13px;">● Aktif Magang</span>
            @endif
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 24px;">
        {{-- Hari Magang --}}
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #d6e3ff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="color: #003e7e; font-size: 20px;">calendar_today</span>
                    </div>
                    <span class="text-label-md" style="color: #424751;">Hari Magang</span>
                </div>
                <p class="text-headline-md" style="color: #191c20; margin-bottom: 8px;">{{ $stats['hari_berjalan'] }} / {{ $stats['hari_total'] }} hari</p>
                @php
                    $hariPercent = $stats['hari_total'] > 0 ? round(($stats['hari_berjalan'] / $stats['hari_total']) * 100) : 0;
                @endphp
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $hariPercent }}%;"></div>
                </div>
            </div>
        </div>

        {{-- Logbook --}}
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #dcfce7; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="color: #166534; font-size: 20px;">menu_book</span>
                    </div>
                    <span class="text-label-md" style="color: #424751;">Logbook</span>
                </div>
                <p class="text-headline-md" style="color: #191c20; margin-bottom: 4px;">{{ $stats['logbook_total'] }} entri</p>
                <p class="text-label-sm" style="color: #737782;">{{ $stats['logbook_approved'] }} disetujui, {{ $stats['logbook_pending'] }} pending</p>
            </div>
        </div>

        {{-- Presensi --}}
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #fef08a; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="color: #854d0e; font-size: 20px;">qr_code</span>
                    </div>
                    <span class="text-label-md" style="color: #424751;">Presensi</span>
                </div>
                <p class="text-headline-md" style="color: #191c20; margin-bottom: 4px;">{{ $stats['presensi_persen'] }}%</p>
                <p class="text-label-sm" style="color: #737782;">({{ $stats['presensi_hadir'] }}/{{ $stats['presensi_total'] }} hari)</p>
            </div>
        </div>

        {{-- Nilai --}}
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #ffdcc6; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="color: #673000; font-size: 20px;">grade</span>
                    </div>
                    <span class="text-label-md" style="color: #424751;">Nilai Akhir</span>
                </div>
                <p class="text-headline-md" style="color: #191c20; margin-bottom: 4px;">{{ $stats['nilai_akhir'] ?? 'Belum dinilai' }}</p>
                <p class="text-label-sm" style="color: #737782;">
                    @if($stats['nilai_dosen'] && $stats['nilai_perusahaan'])
                        Dosen: {{ $stats['nilai_dosen'] }} | Mitra: {{ $stats['nilai_perusahaan'] }}
                    @else
                        Menunggu penilaian lengkap
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Two Column Layout --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
        {{-- Logbook Terbaru --}}
        <div>
            <div class="card" style="margin-bottom: 24px;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between;">
                    <h3 class="text-headline-sm" style="color: #191c20;">Logbook Terbaru</h3>
                    <a href="{{ route('mahasiswa.logbooks.index') }}" class="text-label-md" style="color: #0058be; text-decoration: none;">Lihat Semua →</a>
                </div>
                <div style="padding: 20px;">
                    @if($application->logbooks->isEmpty())
                        <p class="text-body-sm" style="color: #737782; text-align: center; padding: 32px 0;">
                            Belum ada entri logbook. Mulai isi logbook harian Anda.
                        </p>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($application->logbooks()->orderBy('date', 'desc')->take(3)->get() as $logbook)
                                <div style="padding: 12px; border: 1px solid #c2c6d3; border-radius: 8px; background: #ffffff;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 600; font-size: 14px; color: #191c20;">{{ $logbook->date->format('d M Y') }}</span>
                                        @if($logbook->status === 'approved')
                                            <span class="chip-approved" style="font-size: 11px;">Disetujui</span>
                                        @elseif($logbook->status === 'rejected')
                                            <span class="chip-pending" style="background: #fdf2f2; color: #b91c1c; font-size: 11px;">Revisi</span>
                                        @else
                                            <span class="chip-pending" style="font-size: 11px;">Menunggu</span>
                                        @endif
                                    </div>
                                    <p class="text-body-sm" style="color: #424751;">{{ Str::limit($logbook->activity, 120) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Gradient CTA --}}
            @if(!$stats['logbook_hari_ini'])
                <div class="gradient-cta">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; position: relative; z-index: 1;">Tulis Logbook Hari Ini</h3>
                    <p style="font-size: 14px; opacity: 0.9; margin-bottom: 16px; position: relative; z-index: 1;">Catat kegiatan magang Anda untuk hari ini.</p>
                    <a href="{{ route('mahasiswa.logbooks.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #ffffff; color: #1a56a0; font-size: 13px; font-weight: 600; padding: 10px 20px; border-radius: 8px; text-decoration: none; position: relative; z-index: 1;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">edit_note</span>
                        Isi Logbook
                    </a>
                </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div>
            {{-- Mitra Info --}}
            <div class="card" style="margin-bottom: 24px;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
                    <h3 class="text-headline-sm" style="color: #191c20;">Mitra Magang</h3>
                </div>
                <div style="padding: 20px;">
                    <p class="text-label-sm" style="color: #737782; margin-bottom: 2px;">Perusahaan</p>
                    <p class="text-body-sm" style="color: #191c20; font-weight: 600; margin-bottom: 12px;">{{ $application->company->name }}</p>

                    <p class="text-label-sm" style="color: #737782; margin-bottom: 2px;">Alamat</p>
                    <p class="text-body-sm" style="color: #424751; margin-bottom: 12px;">{{ $application->company->address ?? '-' }}</p>

                    <p class="text-label-sm" style="color: #737782; margin-bottom: 2px;">Dosen Pembimbing</p>
                    <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $application->dosen->name ?? 'Belum ditentukan' }}</p>
                </div>
            </div>

            {{-- Presensi Hari Ini QR --}}
            <div class="card">
                <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
                    <h3 class="text-headline-sm" style="color: #191c20;">Presensi Hari Ini</h3>
                </div>
                <div style="padding: 20px; text-align: center;">
                    <p class="text-body-sm" style="color: #424751; margin-bottom: 16px;">
                        Scan QR Code kehadiran di lokasi magang Anda.
                    </p>
                    <a href="{{ route('mahasiswa.attendances.index') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                        <span class="material-symbols-outlined">qr_code</span> Buka Presensi
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    @media (max-width: 1023px) {
        div[style*="grid-template-columns: repeat(4"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        div[style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 640px) {
        div[style*="grid-template-columns: repeat(2"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
