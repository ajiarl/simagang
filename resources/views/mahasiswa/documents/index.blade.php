@extends('layouts.app')

@section('title', 'Dokumen Magang')
@section('page-title', 'Dokumen Magang')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 class="text-display-sm" style="color: #191c20; margin-bottom: 8px;">Dokumen Magang</h2>
    <p class="text-body-sm" style="color: #424751;">Kelola dan unduh semua dokumen administrasi magang Anda.</p>
</div>

@if(!$application)
    {{-- No Approved Application --}}
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 40px 20px;">
            <div style="width: 64px; height: 64px; border-radius: 9999px; background: #ffdad6; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <span class="material-symbols-outlined" style="color: #ba1a1a; font-size: 32px;">folder_off</span>
            </div>
            <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 8px;">Belum Ada Pengajuan yang Disetujui</h3>
            <p class="text-body-sm" style="color: #424751; max-width: 480px; margin: 0 auto 24px;">
                Menu dokumen hanya dapat diakses setelah pengajuan magang Anda disetujui oleh Admin program studi.
            </p>
            <a href="{{ route('mahasiswa.applications.index') }}" class="btn-primary" style="text-decoration: none;">
                Lihat Status Pengajuan
            </a>
        </div>
    </div>
@else
    {{-- Application Exists --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); lg:grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; align-items: start;">
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Info Card --}}
            <div class="card">
                <div class="card-body">
                    <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span class="material-symbols-outlined" style="color: #003e7e;">info</span> Informasi Magang Aktif
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        <div>
                            <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Perusahaan Mitra</p>
                            <p class="text-body-sm" style="color: #191c20; font-weight: 600;">{{ $application->company->name }}</p>
                        </div>
                        <div>
                            <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Periode Magang</p>
                            <p class="text-body-sm" style="color: #191c20; font-weight: 600;">{{ $application->internshipPeriod->name }}</p>
                        </div>
                        <div>
                            <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Status Pengajuan</p>
                            <span class="chip-approved" style="padding: 4px 10px; font-size: 12px; margin-top: 4px;">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document List --}}
            <div class="card">
                <div class="card-body">
                    <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span class="material-symbols-outlined" style="color: #003e7e;">folder_open</span> Berkas yang Diunggah
                    </h3>
                    @if($application->documents->isEmpty())
                        <p class="text-body-sm" style="color: #737782; text-align: center; padding: 20px 0;">Tidak ada dokumen berkas yang diunggah.</p>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($application->documents as $doc)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border: 1px solid #c2c6d3; border-radius: 8px; background: #ffffff;">
                                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                        <span class="chip-pending" style="background: #e2e2e9; color: #424751; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                            {{ strtoupper($doc->type) }}
                                        </span>
                                        <div>
                                            <p class="text-body-sm" style="color: #191c20; font-weight: 500; margin-bottom: 2px;">{{ $doc->original_name ?? $doc->name }}</p>
                                            <p class="text-label-sm" style="color: #737782;">Diunggah {{ $doc->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('mahasiswa.documents.download', $doc) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">download</span> Unduh
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Surat Pengantar Card --}}
        <div>
            <div class="gradient-cta" style="box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.05);">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <span class="material-symbols-outlined" style="color: #ffffff; font-size: 24px;">picture_as_pdf</span>
                </div>
                <h3 class="text-headline-sm" style="color: #ffffff; margin-bottom: 8px;">Surat Pengantar Magang</h3>
                <p class="text-body-sm" style="color: rgba(255, 255, 255, 0.9); margin-bottom: 20px; line-height: 1.5;">
                    Unduh Surat Pengantar Magang resmi yang dikeluarkan oleh program studi untuk diserahkan ke perusahaan mitra.
                </p>
                <a href="{{ route('mahasiswa.documents.surat', $application) }}" class="btn-secondary" style="width: 100%; background: #ffffff; color: #1a56a0; border: none; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 40px;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">download</span> Unduh Surat (PDF)
                </a>
            </div>

            {{-- Sertifikat Card (only for completed) --}}
            @if($application && $application->status === 'completed')
                <div class="card" style="margin-top: 16px; border: 2px solid #003e7e;">
                    <div class="card-body">
                        <div style="width: 44px; height: 44px; border-radius: 8px; background: #003e7e; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <span class="material-symbols-outlined" style="color: #ffffff; font-size: 24px;">workspace_premium</span>
                        </div>
                        <h3 class="text-headline-sm" style="color: #003e7e; margin-bottom: 8px;">Sertifikat Magang</h3>
                        <p class="text-body-sm" style="color: #424751; margin-bottom: 20px; line-height: 1.5;">
                            Selamat! Anda telah menyelesaikan program magang. Unduh sertifikat resmi sebagai bukti penyelesaian magang.
                        </p>
                        <a href="{{ route('mahasiswa.documents.sertifikat', $application) }}"
                           class="btn-primary"
                           style="width: 100%; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 40px;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">download</span> Unduh Sertifikat (PDF)
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endif
@endsection
