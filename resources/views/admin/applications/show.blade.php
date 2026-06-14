@extends('layouts.app')

@section('title', 'Detail Pengajuan Magang')
@section('page-title', 'Detail Pengajuan')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    {{-- Kolom Kiri: Info Detail --}}
    <div>
        <div class="card" style="margin-bottom: 24px;">
            <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between;">
                <h3 class="text-headline-sm" style="color: #191c20;">Informasi Mahasiswa & Perusahaan</h3>
                @if($application->status === 'approved')
                    <span class="chip-approved">Disetujui</span>
                @elseif($application->status === 'submitted')
                    <span class="chip-pending">Menunggu</span>
                @elseif($application->status === 'rejected')
                    <span class="chip-rejected">Ditolak</span>
                @endif
            </div>
            <div style="padding: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Nama Mahasiswa</p>
                        <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->user->name }} ({{ $application->user->nim }})</p>
                    </div>
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Program Studi</p>
                        <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->user->department ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Perusahaan Mitra</p>
                        <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->company->name }}</p>
                    </div>
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Periode Magang</p>
                        <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->internshipPeriod->name }}</p>
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <p class="text-label-sm" style="color: #737782; margin-bottom: 8px;">Motivasi / Tujuan Magang</p>
                    <div style="padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <p class="text-body-md" style="color: #424751; white-space: pre-wrap; margin: 0;">{{ $application->motivation }}</p>
                    </div>
                </div>

                @if($application->status === 'approved')
                    <div style="margin-bottom: 24px;">
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 8px;">Dosen Pembimbing</p>
                        <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->dosen->name ?? '-' }}</p>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Tanggal Mulai</p>
                            <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->start_date ? $application->start_date->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Tanggal Selesai</p>
                            <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->end_date ? $application->end_date->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                @endif
                
                @if($application->status === 'rejected')
                    <div style="margin-top: 24px; padding: 16px; background: #fee2e2; border-radius: 8px;">
                        <p class="text-label-sm" style="color: #991b1b; margin-bottom: 4px; font-weight: 600;">Alasan Penolakan</p>
                        <p class="text-body-md" style="color: #991b1b; margin: 0;">{{ $application->rejection_reason }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Aksi & Dokumen --}}
    <div>
        {{-- Dokumen Persyaratan --}}
        <div class="card" style="margin-bottom: 24px;">
            <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
                <h3 class="text-headline-sm" style="color: #191c20;">Dokumen Syarat</h3>
            </div>
            <div style="padding: 20px;">
                @if($application->documents->isEmpty())
                    <p class="text-body-sm" style="color: #737782; text-align: center;">Tidak ada dokumen</p>
                @else
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($application->documents as $doc)
                            <li style="margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span class="material-symbols-outlined" style="color: #0058be;">description</span>
                                    <span class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $doc->name }}</span>
                                </div>
                                <a href="{{ route('admin.applications.documents.download', [$application, $doc]) }}" class="text-label-sm" style="color: #0058be; text-decoration: none;">Unduh</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- Form Aksi (Hanya jika masih submitted) --}}
        @if($application->status === 'submitted')
            <div class="card" style="margin-bottom: 24px;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
                    <h3 class="text-headline-sm" style="color: #191c20;">Tindakan</h3>
                </div>
                <div style="padding: 20px;">
                    @if($errors->any())
                        <div style="margin-bottom: 16px; padding: 12px; background: #fee2e2; border-radius: 8px; color: #991b1b; font-size: 13px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <h4 style="font-size: 14px; font-weight: 600; color: #191c20; margin-bottom: 12px;">Setujui Pengajuan</h4>
                    <form action="{{ route('admin.applications.approve', $application) }}" method="POST" style="margin-bottom: 24px;">
                        @csrf
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px; color: #424751;">Dosen Pembimbing</label>
                            <select name="dosen_id" style="width: 100%; padding: 8px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 13px;" required>
                                <option value="">-- Pilih Dosen --</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px; color: #424751;">Tanggal Mulai</label>
                            <input type="date" name="start_date" style="width: 100%; padding: 8px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 13px;" required>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px; color: #424751;">Tanggal Selesai</label>
                            <input type="date" name="end_date" style="width: 100%; padding: 8px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 13px;" required>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; background: #166534;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">check_circle</span> Setujui
                        </button>
                    </form>

                    <hr style="border: 0; border-top: 1px solid #e2e2e9; margin: 0 0 20px 0;">

                    <h4 style="font-size: 14px; font-weight: 600; color: #991b1b; margin-bottom: 12px;">Tolak Pengajuan</h4>
                    <form action="{{ route('admin.applications.reject', $application) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px; color: #424751;">Alasan Penolakan</label>
                            <textarea name="rejection_reason" rows="2" style="width: 100%; padding: 8px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 13px; resize: vertical;" required placeholder="Alasan penolakan..."></textarea>
                        </div>
                        <button type="submit" class="btn-secondary" style="width: 100%; color: #991b1b; border-color: #991b1b; background: #fef2f2;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">cancel</span> Tolak
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Cetak Surat Pengantar --}}
        @if($application->status === 'approved')
            <div class="card">
                <div style="padding: 20px; text-align: center;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <span class="material-symbols-outlined" style="font-size: 28px;">picture_as_pdf</span>
                    </div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #191c20; margin-bottom: 8px;">Surat Pengantar Magang</h4>
                    <p style="font-size: 13px; color: #737782; margin-bottom: 16px;">Surat resmi permohonan magang untuk dikirim ke perusahaan.</p>
                    <a href="{{ route('admin.applications.pdf', $application) }}" target="_blank" class="btn-primary" style="width: 100%;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">download</span> Unduh PDF
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
