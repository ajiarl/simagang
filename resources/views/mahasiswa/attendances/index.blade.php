@extends('layouts.app')

@section('title', 'Presensi Harian')
@section('page-title', 'QR Code Presensi')

@section('content')

@if(!$hasApplication)
<div class="card" style="padding: 40px 20px; text-align: center;">
    <span class="material-symbols-outlined" style="font-size: 48px; color: #737782; margin-bottom: 16px;">qr_code_scanner</span>
    <p class="text-body-md" style="color: #424751; margin-bottom: 8px;">Anda belum memiliki pengajuan magang yang disetujui.</p>
    <p class="text-body-sm" style="color: #737782;">Presensi harian hanya tersedia untuk mahasiswa yang sedang magang aktif.</p>
</div>
@else

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
    
    {{-- Kolom Kiri: QR Hari Ini --}}
    <div class="card">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
            <h3 class="text-headline-sm" style="color: #191c20;">Presensi Hari Ini</h3>
            <p class="text-body-sm" style="color: #737782;">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div style="padding: 24px; text-align: center;">
            
            @if(session('success'))
                <div style="margin-bottom: 16px; padding: 12px; background: #dcfce7; border-radius: 8px; color: #166534; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(!$todayAttendance)
                <p class="text-body-sm" style="color: #424751; margin-bottom: 20px;">
                    Anda belum membuat QR Code presensi untuk hari ini. Silakan buat sekarang untuk ditunjukkan kepada petugas/pembimbing lapangan.
                </p>
                <form action="{{ route('mahasiswa.attendances.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary" style="margin: 0 auto;">
                        <span class="material-symbols-outlined" style="font-size: 20px;">qr_code</span> Buat QR Presensi
                    </button>
                </form>
            @else
                <div style="background: #ffffff; padding: 20px; border: 1px solid #c2c6d3; border-radius: 12px; display: inline-block; margin-bottom: 16px;">
                    {!! QrCode::size(200)->generate($todayAttendance->qr_token) !!}
                </div>
                
                @if($todayAttendance->verified_at)
                    <div style="padding: 12px; background: #dcfce7; border-radius: 8px; color: #166534;">
                        <span class="material-symbols-outlined" style="font-size: 24px; margin-bottom: 4px;">verified</span>
                        <p class="text-body-md" style="font-weight: 600;">Berhasil Diverifikasi</p>
                        <p class="text-body-sm">Pukul {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }} WIB</p>
                    </div>
                @else
                    <div style="padding: 12px; background: #fef08a; border-radius: 8px; color: #854d0e;">
                        <span class="material-symbols-outlined" style="font-size: 24px; margin-bottom: 4px;">hourglass_empty</span>
                        <p class="text-body-md" style="font-weight: 600;">Menunggu Verifikasi</p>
                        <p class="text-body-sm">Tunjukkan QR ini ke pembimbing.</p>
                        <br>
                        <small style="user-select: all; background: rgba(0,0,0,0.05); padding: 4px 8px; border-radius: 4px; font-family: monospace;">{{ $todayAttendance->qr_token }}</small>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Kolom Kanan: Riwayat Presensi --}}
    <div class="card">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
            <h3 class="text-headline-sm" style="color: #191c20;">Riwayat Kehadiran</h3>
        </div>
        
        <div style="overflow-x: auto;">
            @if($attendances->isEmpty())
                <div style="padding: 40px 20px; text-align: center;">
                    <p class="text-body-md" style="color: #737782;">Belum ada riwayat kehadiran.</p>
                </div>
            @else
                <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Check In</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr style="border-bottom: 1px solid #e2e2e9;">
                            <td class="text-body-sm" style="padding: 16px 20px; color: #191c20; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                                {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') . ' WIB' : '-' }}
                            </td>
                            <td style="padding: 16px 20px;">
                                @if($attendance->verified_at)
                                    <span class="chip-approved">Hadir</span>
                                @else
                                    <span class="chip-pending">Belum Verifikasi</span>
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
</div>

@endif
@endsection
