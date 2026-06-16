@extends('layouts.app')

@section('title', 'Logbook Harian')
@section('page-title', 'Logbook')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; justify-content: space-between;">
        <h3 class="text-headline-sm" style="color: #191c20;">Riwayat Logbook</h3>
        <a href="{{ route('mahasiswa.logbooks.create') }}" class="btn-primary" style="text-decoration: none;">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Isi Logbook
        </a>
    </div>

    @if(session('success'))
        <div style="margin: 16px 20px; padding: 12px; background: #dcfce7; border-radius: 8px; color: #166534; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        @if($logbooks->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #737782; margin-bottom: 16px;">menu_book</span>
                <p class="text-body-md" style="color: #424751; margin-bottom: 8px;">Belum ada entri logbook.</p>
                <p class="text-body-sm" style="color: #737782;">Silakan isi logbook untuk mencatat kegiatan harian magang Anda.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Tanggal</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Kegiatan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: right; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logbooks as $logbook)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td class="text-body-sm" style="padding: 16px 20px; color: #191c20; font-weight: 500; vertical-align: top;">
                            {{ $logbook->date->format('d M Y') }}
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751; vertical-align: top;">
                            {{ Str::limit($logbook->activity, 80) }}
                            @if($logbook->supervisor_note)
                                <div style="margin-top: 8px; padding: 8px; background: #fee2e2; border-radius: 4px; font-size: 12px; color: #991b1b;">
                                    <strong>Catatan Dosen:</strong> {{ $logbook->supervisor_note }}
                                </div>
                            @endif
                        </td>
                        <td style="padding: 16px 20px; vertical-align: top;">
                            @if($logbook->status === 'approved')
                                <span class="chip-approved">Disetujui</span>
                            @elseif($logbook->status === 'submitted')
                                <span class="chip-pending">Menunggu Review</span>
                            @elseif($logbook->status === 'rejected')
                                <span class="chip-rejected">Revisi</span>
                            @else
                                <span class="chip-pending" style="background: #ededf4; color: #424751;">Draft</span>
                            @endif
                        </td>
                        <td style="padding: 16px 20px; text-align: right; vertical-align: top;">
                            @if(in_array($logbook->status, ['draft', 'rejected']))
                                <a href="{{ route('mahasiswa.logbooks.edit', $logbook) }}" class="btn-secondary" style="padding: 10px 14px; font-size: 13px; text-decoration: none;">
                                    Edit
                                </a>
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
