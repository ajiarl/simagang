@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')

@section('content')
{{-- Breadcrumb Back --}}
<div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
    <a href="{{ route('admin.students.index') }}" class="btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Daftar
    </a>
    <a href="{{ route('admin.students.edit', $student) }}" class="btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
        <span class="material-symbols-outlined" style="font-size: 16px;">edit</span> Edit Data
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px;">

    {{-- Profil Card --}}
    <div class="card">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e2e9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <h3 class="text-headline-sm" style="color: #191c20; margin: 0;">Profil Mahasiswa</h3>
        </div>
        <div style="padding: 24px;">
            {{-- Avatar --}}
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 24px; flex-wrap: wrap;">
                <div style="width: 72px; height: 72px; border-radius: 50%; background: #d3e4ff; color: #0058be; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; flex-shrink: 0;">
                    {{ $student->initials }}
                </div>
                <div>
                    <p class="text-headline-sm" style="color: #191c20; font-weight: 600; margin: 0 0 4px 0;">{{ $student->name }}</p>
                    <p class="text-body-sm" style="color: #737782; margin: 0;">{{ $student->nim ?? 'NIM belum diatur' }}</p>
                </div>
            </div>
            {{-- Detail Fields --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div>
                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">Email</span>
                    <span class="text-body-md" style="color: #191c20;">{{ $student->email }}</span>
                </div>
                <div>
                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">No. Telepon</span>
                    <span class="text-body-md" style="color: #191c20;">{{ $student->phone ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Pengajuan --}}
    <div class="card">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e2e9;">
            <h3 class="text-headline-sm" style="color: #191c20; margin: 0;">Riwayat Pengajuan Magang</h3>
        </div>
        <div style="overflow-x: auto;">
            @if($student->internshipApplications->isEmpty())
                <div style="padding: 40px 20px; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 48px; color: #c2c6d3; display: block; margin-bottom: 12px;">folder_open</span>
                    <p class="text-body-md" style="color: #737782;">Belum ada pengajuan magang.</p>
                </div>
            @else
                <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan</th>
                                <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Periode</th>
                                <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                                <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->internshipApplications as $app)
                            <tr style="border-bottom: 1px solid #e2e2e9;">
                                <td class="text-body-sm" style="padding: 16px 20px; color: #191c20;">{{ optional($app->company)->name ?? '-' }}</td>
                                <td class="text-body-sm" style="padding: 16px 20px; color: #191c20;">{{ optional($app->internshipPeriod)->name ?? '-' }}</td>
                                <td style="padding: 16px 20px;">
                                    @if($app->status === 'approved')
                                        <span class="chip-approved">Diterima</span>
                                    @elseif($app->status === 'completed')
                                        <span class="chip-approved">Selesai</span>
                                    @elseif($app->status === 'rejected')
                                        <span class="chip-rejected">Ditolak</span>
                                    @else
                                        <span class="chip-pending">Menunggu</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 20px;">
                                    <a href="{{ route('admin.applications.show', $app) }}" style="color: #0058be; text-decoration: none; font-size: 14px; font-weight: 500;">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
