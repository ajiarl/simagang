@extends('layouts.app')

@section('title', 'Kelola Pengajuan Magang')
@section('page-title', 'Daftar Pengajuan Magang')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <h3 class="text-headline-sm" style="color: #191c20;">Semua Pengajuan</h3>
        
        <div style="display: flex; gap: 12px; align-items: center;">
            <form action="{{ route('admin.applications.index') }}" method="GET" style="display: flex; gap: 12px;">
                <select name="status" style="padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; background: #ffffff;" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Menunggu (Submitted)</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                </select>
            </form>
            <a href="{{ route('admin.reports.assessments.export') }}" class="btn-primary" style="text-decoration: none; padding: 8px 16px; display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-outlined" style="font-size: 18px;">download</span> Export Nilai
            </a>
        </div>
    </div>
    <div style="overflow-x: auto;">
        @if($applications->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <p class="text-body-md" style="color: #737782;">Belum ada pengajuan magang yang ditemukan.</p>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Periode</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal Pengajuan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: center; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td style="padding: 16px 20px;">
                            <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $app->user->name }}</p>
                            <p class="text-label-sm" style="color: #737782;">{{ $app->user->nim }}</p>
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
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
                        <td style="padding: 16px 20px;">
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.applications.show', $app) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 13px; text-decoration: none;">
                                    Lihat Detail
                                </a>
                                @if($app->status === 'approved')
                                    <a href="{{ route('admin.reports.pdf', $app) }}" target="_blank" class="btn-secondary" style="padding: 6px 12px; font-size: 13px; text-decoration: none; color: #ba1a1a; border-color: #ba1a1a;">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">picture_as_pdf</span>
                                        PDF
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @if($applications->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3;">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
