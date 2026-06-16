@extends('layouts.app')

@section('title', 'Manajemen Periode Magang')
@section('page-title', 'Periode Magang')

@section('content')
<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <h2>Daftar Periode Magang</h2>
    <a href="{{ route('admin.periods.create') }}" style="background-color: #003e7e; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Tambah Periode</a>
</div>

@if($activePeriod)
<div style="background-color: #e6f4ea; border: 1px solid #1e8e3e; padding: 16px; margin-bottom: 24px; border-radius: 8px;">
    <h3 style="margin-top: 0; color: #1e8e3e;">Periode Aktif Saat Ini</h3>
    <p><strong>Nama:</strong> {{ $activePeriod->name }}</p>
    <p><strong>Mulai:</strong> {{ $activePeriod->start_date->format('d M Y') }}</p>
    <p><strong>Selesai:</strong> {{ $activePeriod->end_date->format('d M Y') }}</p>
</div>
@else
<div style="background-color: #fce8e6; border: 1px solid #d93025; padding: 16px; margin-bottom: 24px; border-radius: 8px;">
    <p style="color: #d93025; margin: 0;">Tidak ada periode magang yang aktif. Silakan aktifkan salah satu periode.</p>
</div>
@endif

<div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">
    <thead>
        <tr style="background-color: #f1f1f1;">
            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Nama Periode</th>
            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Tanggal Mulai</th>
            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Tanggal Selesai</th>
            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Status</th>
            <th style="padding: 12px; border: 1px solid #ccc; text-align: left;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($periods as $period)
        <tr>
            <td style="padding: 12px; border: 1px solid #ccc;">{{ $period->name }}</td>
            <td style="padding: 12px; border: 1px solid #ccc;">{{ $period->start_date->format('d M Y') }}</td>
            <td style="padding: 12px; border: 1px solid #ccc;">{{ $period->end_date->format('d M Y') }}</td>
            <td style="padding: 12px; border: 1px solid #ccc;">
                @if($period->is_active)
                    <span style="background-color: #1e8e3e; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">Aktif</span>
                @else
                    <span style="background-color: #ccc; color: black; padding: 4px 8px; border-radius: 12px; font-size: 12px;">Tidak Aktif</span>
                @endif
            </td>
            <td style="padding: 12px; border: 1px solid #ccc;">
                <a href="{{ route('admin.periods.edit', $period) }}">Edit</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="padding: 12px; border: 1px solid #ccc; text-align: center;">Belum ada data periode magang.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
