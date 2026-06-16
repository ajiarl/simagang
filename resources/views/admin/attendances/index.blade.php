@extends('layouts.app')

@section('title', 'Rekap Kehadiran')
@section('page-title', 'Rekap Kehadiran Seluruh Mahasiswa')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; justify-content: space-between; align-items: center;">
        <h3 class="text-headline-sm" style="color: #191c20;">Filter Rekap Kehadiran</h3>
        <a href="{{ route('admin.reports.attendances.export') }}" class="btn-primary" style="text-decoration: none; padding: 8px 16px; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 18px;">download</span> Export Excel
        </a>
    </div>
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
        <form action="{{ route('admin.attendances.index') }}" method="GET" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label for="month" class="text-label-sm" style="display: block; color: #424751; margin-bottom: 4px;">Bulan</label>
                <input type="month" name="month" id="month" value="{{ request('month') }}" style="padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px;">
            </div>
            <div>
                <label for="status" class="text-label-sm" style="display: block; color: #424751; margin-bottom: 4px;">Status</label>
                <select name="status" id="status" style="padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px; min-width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Hadir (Terverifikasi)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Belum Diverifikasi</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn-secondary" style="padding: 8px 16px;">Filter</button>
                <a href="{{ route('admin.attendances.index') }}" class="btn-secondary" style="padding: 8px 16px; text-decoration: none; border-color: transparent; background: transparent;">Reset</a>
            </div>
        </form>
    </div>

    <div style="overflow-x: auto;">
        @if($attendances->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <p class="text-body-md" style="color: #737782;">Data kehadiran tidak ditemukan.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Jam Masuk</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td class="text-body-sm" style="padding: 16px 20px; color: #191c20; font-weight: 500;">
                            {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}
                        </td>
                        <td style="padding: 16px 20px;">
                            <p class="text-body-sm" style="color: #191c20;">{{ $attendance->user->name }}</p>
                            <p class="text-label-sm" style="color: #737782;">{{ $attendance->user->nim }}</p>
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                            {{ $attendance->internshipApplication->company->name ?? '-' }}
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') . ' WIB' : '-' }}
                        </td>
                        <td style="padding: 16px 20px;">
                            @if($attendance->verified_at)
                                <span class="chip-approved">Hadir</span>
                            @else
                                <span class="chip-pending">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
</div>
            
            <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3;">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
