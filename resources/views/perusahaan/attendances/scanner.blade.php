@extends('layouts.app')

@section('title', 'Verifikasi Kehadiran')
@section('page-title', 'Scanner Presensi')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    
    <div class="card" style="margin-bottom: 24px; padding: 32px 24px; text-align: center;">
        <span class="material-symbols-outlined" style="font-size: 64px; color: #0058be; margin-bottom: 16px;">qr_code_scanner</span>
        <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 8px;">Verifikasi Kehadiran Mahasiswa</h3>
        <p class="text-body-sm" style="color: #737782; margin-bottom: 32px;">
            Masukkan Token QR mahasiswa di bawah ini untuk memverifikasi kehadiran mereka hari ini.
        </p>

        @if(session('success'))
            <div style="margin-bottom: 24px; padding: 12px; background: #dcfce7; border-radius: 8px; color: #166534; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;; flex-wrap: wrap;">
                <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="margin-bottom: 24px; padding: 12px; background: #fee2e2; border-radius: 8px; color: #991b1b; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px;; flex-wrap: wrap;">
                <span class="material-symbols-outlined" style="font-size: 20px;">error</span>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="margin-bottom: 24px; padding: 16px; background: #fee2e2; border-radius: 8px; color: #991b1b; font-size: 14px; text-align: left;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('perusahaan.attendances.verify') }}" method="POST">
            @csrf
            <div style="margin-bottom: 24px; text-align: left;">
                <label for="qr_token" class="text-label-md" style="display: block; color: #191c20; margin-bottom: 8px;">Token QR Mahasiswa</label>
                <input type="text" name="qr_token" id="qr_token" placeholder="Contoh: 123e4567-e89b-12d3-a456-426614174000" style="width: 100%; padding: 12px 16px; font-family: monospace; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 16px;" required autofocus autocomplete="off">
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                <span class="material-symbols-outlined">verified</span> Verifikasi Kehadiran
            </button>
        </form>

        <div style="margin-top: 24px;">
            <a href="{{ route('perusahaan.attendances.index') }}" style="color: #0058be; text-decoration: none; font-size: 14px; font-weight: 500;">
                Lihat Riwayat Kehadiran Hari Ini
            </a>
        </div>
    </div>
</div>
@endsection
