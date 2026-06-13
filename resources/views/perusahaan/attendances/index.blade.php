@extends('layouts.app')

@section('title', 'Rekap Presensi Harian')
@section('page-title', 'Kehadiran Mahasiswa')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; justify-content: space-between; align-items: center;">
        <h3 class="text-headline-sm" style="color: #191c20;">Riwayat Kehadiran Mahasiswa</h3>
        <a href="{{ route('perusahaan.attendances.scanner') }}" class="btn-primary" style="text-decoration: none;">
            <span class="material-symbols-outlined" style="font-size: 18px;">qr_code_scanner</span> Scan QR
        </a>
    </div>

    <div style="overflow-x: auto;">
        @if($attendances->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <p class="text-body-md" style="color: #737782;">Belum ada data kehadiran.</p>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Jam Masuk</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Diverifikasi Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td class="text-body-sm" style="padding: 16px 20px; color: #191c20; font-weight: 500;">
                            {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #191c20;">
                            {{ $attendance->user->name }}
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                            @if($attendance->check_in)
                                {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }} WIB
                            @else
                                <span class="chip-pending">Belum Verifikasi</span>
                            @endif
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #737782;">
                            {{ $attendance->verifier ? $attendance->verifier->name : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
