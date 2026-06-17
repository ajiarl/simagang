@extends('layouts.app')

@section('title', 'Detail Dosen Pembimbing')
@section('page-title', 'Detail Dosen')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.lecturers.index') }}" class="btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Daftar
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
    
    {{-- Card Profil Dosen --}}
    <div class="card">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e2e9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <h3 class="text-headline-sm" style="color: #191c20; margin: 0;">Profil Dosen</h3>
            <a href="{{ route('admin.lecturers.edit', $lecturer) }}" class="btn-primary" style="text-decoration: none; padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px;">
                <span class="material-symbols-outlined" style="font-size: 16px;">edit</span> Edit Profil
            </a>
        </div>
        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">
                <div>
                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">Nama Lengkap</span>
                    <span class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $lecturer->name }}</span>
                </div>
                <div>
                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">Email</span>
                    <span class="text-body-md" style="color: #191c20;">{{ $lecturer->email }}</span>
                </div>
                <div>
                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">No. Telepon</span>
                    <span class="text-body-md" style="color: #191c20;">{{ $lecturer->phone ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">Fakultas</span>
                    <span class="text-body-md" style="color: #191c20;">{{ $lecturer->faculty ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">Departemen / Program Studi</span>
                    <span class="text-body-md" style="color: #191c20;">{{ $lecturer->department ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Mahasiswa Bimbingan --}}
    <div class="card">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e2e9;">
            <h3 class="text-headline-sm" style="color: #191c20; margin: 0;">Mahasiswa Bimbingan</h3>
        </div>
        <div style="overflow-x: auto;">
            @if($lecturer->supervisedApplications->isEmpty())
                <div style="padding: 40px 20px; text-align: center;">
                    <span class="material-symbols-outlined" style="font-size: 48px; color: #c2c6d3; display: block; margin-bottom: 12px;">group_off</span>
                    <p class="text-body-md" style="color: #737782;">Belum ada mahasiswa yang dibimbing.</p>
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Periode Magang</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lecturer->supervisedApplications as $application)
                        <tr style="border-bottom: 1px solid #e2e2e9;">
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #191c20; font-weight: 500;">
                                    <a href="{{ route('admin.students.show', $application->user) }}" style="color: #0058be; text-decoration: none;">
                                        {{ optional($application->user)->name ?? 'Data Mahasiswa Terhapus' }}
                                    </a>
                                </p>
                                <p class="text-label-sm" style="color: #737782;">{{ optional($application->user)->nim ?? '-' }}</p>
                            </td>
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #191c20;">{{ optional($application->company)->name ?? 'Tidak Ada' }}</p>
                            </td>
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #191c20;">{{ optional($application->internshipPeriod)->name ?? 'Tidak Ada' }}</p>
                            </td>
                            <td style="padding: 16px 20px;">
                                @if($application->status == 'approved')
                                    <span class="chip-approved">Aktif</span>
                                @elseif($application->status == 'completed')
                                    <span class="chip-approved" style="background: #e2e2e9; color: #424751;">Selesai</span>
                                @else
                                    <span class="chip-pending">Lainnya</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
