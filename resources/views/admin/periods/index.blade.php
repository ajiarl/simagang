@extends('layouts.app')

@section('title', 'Manajemen Periode Magang')
@section('page-title', 'Daftar Periode Magang')

@section('content')
{{-- Page Header --}}
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <h2 class="text-display-lg" style="color: #191c20;">Periode Magang</h2>
    <a href="{{ route('admin.periods.create') }}" class="btn-primary" style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Tambah Periode
    </a>
</div>

{{-- Active Period Status --}}
@if($activePeriod)
<div class="card" style="margin-bottom: 24px; border-left: 4px solid #1e8e3e;">
    <div style="padding: 16px 20px;">
        <h3 class="text-label-lg" style="margin-top: 0; margin-bottom: 12px; color: #1e8e3e; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
            Periode Aktif Saat Ini
        </h3>
        <div style="display: flex; gap: 24px; flex-wrap: wrap;">
            <div>
                <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Nama Periode</p>
                <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $activePeriod->name }}</p>
            </div>
            <div>
                <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Tanggal Mulai</p>
                <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $activePeriod->start_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Tanggal Selesai</p>
                <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $activePeriod->end_date->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@else
<div class="card" style="margin-bottom: 24px; border-left: 4px solid #ba1a1a;">
    <div style="padding: 16px 20px; display: flex; align-items: center; gap: 12px;">
        <span class="material-symbols-outlined" style="font-size: 24px; color: #ba1a1a;">error</span>
        <p class="text-body-md" style="color: #ba1a1a; margin: 0; font-weight: 500;">Tidak ada periode magang yang aktif. Silakan aktifkan salah satu periode.</p>
    </div>
</div>
@endif

{{-- Data Table --}}
<div class="card">
    <div style="overflow-x: auto;">
        @if($periods->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #c2c6d3; display: block; margin-bottom: 12px;">date_range</span>
                <p class="text-body-md" style="color: #737782;">Belum ada data periode magang.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Nama Periode</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal Mulai</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal Selesai</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: center; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periods as $period)
                        <tr style="border-bottom: 1px solid #e2e2e9;">
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $period->name }}</p>
                            </td>
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #424751;">{{ $period->start_date->format('d M Y') }}</p>
                            </td>
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #424751;">{{ $period->end_date->format('d M Y') }}</p>
                            </td>
                            <td style="padding: 16px 20px;">
                                @if($period->is_active)
                                    <span class="chip-approved" style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; background: #e6f4ea; color: #1e8e3e; font-size: 12px; font-weight: 500;">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">check_circle</span> Aktif
                                    </span>
                                @else
                                    <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; background: #f1f4f9; color: #424751; font-size: 12px; font-weight: 500;">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">cancel</span> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px 20px;">
                                <div style="display: flex; gap: 8px; justify-content: center; align-items: center; flex-wrap: wrap;">
                                    <a href="{{ route('admin.periods.edit', $period) }}" class="btn-secondary" style="padding: 10px 14px; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">edit</span> Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @if(method_exists($periods, 'hasPages') && $periods->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3;">
            {{ $periods->links() }}
        </div>
    @endif
</div>
@endsection
