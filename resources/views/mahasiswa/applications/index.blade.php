@extends('layouts.app')

@section('title', 'Status Pengajuan Magang')
@section('page-title', 'Pengajuan Magang')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between;">
        <h3 class="text-headline-sm" style="color: #191c20;">Riwayat Pengajuan</h3>
        <a href="{{ route('mahasiswa.applications.create') }}" class="btn-primary" style="text-decoration: none;">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Buat Pengajuan
        </a>
    </div>
    <div style="overflow-x: auto;">
        @if($applications->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #737782; margin-bottom: 16px;">description</span>
                <p class="text-body-md" style="color: #424751; margin-bottom: 8px;">Belum ada pengajuan magang.</p>
                <p class="text-body-sm" style="color: #737782;">Silakan buat pengajuan magang baru untuk memulai.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Periode</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal Pengajuan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: right; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td class="text-body-sm" style="padding: 16px 20px; color: #191c20; font-weight: 500;">
                            {{ $app->company->name }}
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                            {{ $app->internshipPeriod->name }}
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #737782;">
                            {{ $app->created_at->format('d M Y') }}
                        </td>
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
                        <td style="padding: 16px 20px; text-align: right;">
                            @if($app->status === 'rejected')
                                <button type="button" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;" onclick="alert('Alasan penolakan:\n{{ addslashes($app->rejection_reason) }}')">
                                    Lihat Alasan
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
</div>
        @endif
    </div>
</div>
@endsection
