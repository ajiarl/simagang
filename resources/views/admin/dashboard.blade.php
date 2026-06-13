@extends('layouts.app')

@section('title', 'Dashboard Administrator')
@section('page-title', 'Dashboard')

@section('content')
{{-- Welcome Banner --}}
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body">
        <h2 class="text-display-lg" style="color: #191c20; margin-bottom: 4px;">
            Dashboard Administrator
        </h2>
        <p class="text-body-md" style="color: #424751;">
            Ringkasan sistem magang — {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>
</div>

{{-- Stats Grid --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 24px;">
    {{-- Total Mahasiswa --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #d6e3ff; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #003e7e; font-size: 20px;">school</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Total Mahasiswa</span>
            </div>
            <p class="text-headline-md" style="color: #191c20;">{{ $stats['total_mahasiswa'] }}</p>
        </div>
    </div>

    {{-- Magang Aktif --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #dcfce7; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #166534; font-size: 20px;">work</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Magang Aktif</span>
            </div>
            <p class="text-headline-md" style="color: #191c20;">{{ $stats['mahasiswa_aktif'] }}</p>
        </div>
    </div>

    {{-- Perusahaan Mitra --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fef08a; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #854d0e; font-size: 20px;">business</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Perusahaan Mitra</span>
            </div>
            <p class="text-headline-md" style="color: #191c20;">{{ $stats['total_perusahaan'] }}</p>
        </div>
    </div>

    {{-- Pengajuan Pending --}}
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #ffdcc6; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #673000; font-size: 20px;">hourglass_top</span>
                </div>
                <span class="text-label-md" style="color: #424751;">Pengajuan Pending</span>
            </div>
            <p class="text-headline-md" style="color: #191c20;">{{ $stats['pengajuan_pending'] }}</p>
            @if($stats['pengajuan_pending'] > 0)
                <span class="chip-rejected" style="margin-top: 8px;">{{ $stats['pengajuan_pending'] }} perlu diproses</span>
            @endif
        </div>
    </div>
</div>

{{-- Two Column Layout --}}
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    {{-- Pengajuan Terbaru --}}
    <div class="card">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between;">
            <h3 class="text-headline-sm" style="color: #191c20;">Pengajuan Terbaru</h3>
            <a href="{{ route('admin.applications.index') }}" class="text-label-md" style="color: #0058be; text-decoration: none;">Lihat Semua →</a>
        </div>
        <div style="overflow-x: auto;">
            @if($stats['recent_applications']->isEmpty())
                <div style="padding: 20px;">
                    <p class="text-body-sm" style="color: #737782; text-align: center; padding: 32px 0;">
                        Belum ada pengajuan masuk.
                    </p>
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_applications'] as $app)
                        <tr style="border-bottom: 1px solid #e2e2e9;">
                            <td class="text-body-sm" style="padding: 16px 20px; color: #191c20;">{{ $app->user->name }}</td>
                            <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">{{ $app->company->name }}</td>
                            <td class="text-body-sm" style="padding: 16px 20px; color: #737782;">{{ $app->created_at->format('d M Y') }}</td>
                            <td style="padding: 16px 20px;">
                                @if($app->status === 'approved')
                                    <span class="chip-approved">Disetujui</span>
                                @elseif($app->status === 'submitted')
                                    <span class="chip-pending">Menunggu</span>
                                @elseif($app->status === 'rejected')
                                    <span class="chip-rejected">Ditolak</span>
                                @else
                                    <span class="chip-pending" style="background: #ededf4; color: #424751;">Draft</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- System Alerts --}}
    <div class="card">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
            <h3 class="text-headline-sm" style="color: #191c20;">Informasi Sistem</h3>
        </div>
        <div style="padding: 20px;">
            @if($stats['periode_aktif'])
                <div style="display: flex; align-items: start; gap: 10px; padding: 12px 0; border-bottom: 1px solid #e2e2e9;">
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #166534; margin-top: 2px;">check_circle</span>
                    <div>
                        <p class="text-body-sm" style="color: #191c20; font-weight: 500;">Periode Aktif</p>
                        <p class="text-label-sm" style="color: #737782;">{{ $stats['periode_aktif']->name }}</p>
                    </div>
                </div>
            @else
                <div style="display: flex; align-items: start; gap: 10px; padding: 12px 0; border-bottom: 1px solid #e2e2e9;">
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #ba1a1a; margin-top: 2px;">warning</span>
                    <div>
                        <p class="text-body-sm" style="color: #191c20; font-weight: 500;">Tidak ada periode aktif</p>
                        <p class="text-label-sm" style="color: #737782;">Buat periode magang baru.</p>
                    </div>
                </div>
            @endif

            <div style="display: flex; align-items: start; gap: 10px; padding: 12px 0; border-bottom: 1px solid #e2e2e9;">
                <span class="material-symbols-outlined" style="font-size: 18px; color: #0058be; margin-top: 2px;">today</span>
                <div>
                    <p class="text-body-sm" style="color: #191c20; font-weight: 500;">Presensi Hari Ini</p>
                    <p class="text-label-sm" style="color: #737782;">{{ $stats['presensi_hari_ini'] }} mahasiswa hadir</p>
                </div>
            </div>

            <div style="display: flex; align-items: start; gap: 10px; padding: 12px 0;">
                <span class="material-symbols-outlined" style="font-size: 18px; color: #673000; margin-top: 2px;">rate_review</span>
                <div>
                    <p class="text-body-sm" style="color: #191c20; font-weight: 500;">Logbook Pending Review</p>
                    <p class="text-label-sm" style="color: #737782;">{{ $stats['logbook_pending'] }} entri menunggu review</p>
                </div>
            </div>
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
