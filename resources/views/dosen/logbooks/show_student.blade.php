@extends('layouts.app')

@section('title', 'Detail Logbook Mahasiswa')
@section('page-title', 'Review Logbook: ' . $application->user->name)

@section('content')
<div style="margin-bottom: 24px; display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
    
    {{-- Info Mahasiswa --}}
    <div class="card" style="flex: 1; min-width: 300px;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
            <h3 class="text-headline-sm" style="color: #191c20;">Profil Mahasiswa</h3>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Nama Mahasiswa</p>
                    <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->user->name }} ({{ $application->user->nim }})</p>
                </div>
                <div>
                    <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Perusahaan</p>
                    <p class="text-body-md" style="color: #191c20; font-weight: 500;">{{ $application->company->name }}</p>
                </div>
                <div style="grid-column: span 2;">
                    <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Periode Pelaksanaan</p>
                    <p class="text-body-md" style="color: #191c20; font-weight: 500;">
                        {{ $application->start_date ? $application->start_date->format('d M Y') : '-' }} 
                        s/d 
                        {{ $application->end_date ? $application->end_date->format('d M Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 16px;">Daftar Logbook</h3>

@if($application->logbooks->isEmpty())
    <div class="card" style="padding: 40px 20px; text-align: center;">
        <p class="text-body-md" style="color: #737782;">Mahasiswa ini belum memiliki entri logbook.</p>
    </div>
@else
    <div style="display: flex; flex-direction: column; gap: 16px;">
        @foreach($application->logbooks as $logbook)
            <div class="card">
                <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; justify-content: space-between; align-items: center;">
                    <h4 class="text-headline-sm" style="font-size: 16px; color: #191c20;">
                        {{ $logbook->date->translatedFormat('l, d F Y') }}
                    </h4>
                    <div>
                        @if($logbook->status === 'approved')
                            <span class="chip-approved">Disetujui</span>
                        @elseif($logbook->status === 'submitted')
                            <span class="chip-pending" style="background: #fef08a; color: #854d0e;">Menunggu Review</span>
                        @elseif($logbook->status === 'rejected')
                            <span class="chip-rejected">Revisi</span>
                        @else
                            <span class="chip-pending" style="background: #ededf4; color: #424751;">Draft (Belum disubmit)</span>
                        @endif
                    </div>
                </div>
                <div style="padding: 20px;">
                    <div style="margin-bottom: 16px;">
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 8px;">Kegiatan</p>
                        <p class="text-body-md" style="color: #191c20; white-space: pre-wrap; margin: 0;">{{ $logbook->activity }}</p>
                    </div>
                    @if($logbook->learning)
                        <div style="margin-bottom: 16px;">
                            <p class="text-label-sm" style="color: #737782; margin-bottom: 8px;">Pembelajaran / Insight</p>
                            <p class="text-body-md" style="color: #191c20; white-space: pre-wrap; margin: 0;">{{ $logbook->learning }}</p>
                        </div>
                    @endif
                    
                    @if($logbook->status === 'submitted')
                        <hr style="border: 0; border-top: 1px solid #e2e2e9; margin: 20px 0;">
                        
                        <form action="{{ route('dosen.logbooks.review', $logbook) }}" method="POST">
                            @csrf
                            <p class="text-label-sm" style="color: #191c20; font-weight: 600; margin-bottom: 12px;">Tinjauan Dosen Pembimbing</p>
                            
                            <div style="margin-bottom: 16px;">
                                <label for="note_{{ $logbook->id }}" style="display: block; font-size: 13px; color: #424751; margin-bottom: 8px;">Catatan (Opsional jika Setuju, Wajib jika Revisi)</label>
                                <textarea name="supervisor_note" id="note_{{ $logbook->id }}" rows="2" style="width: 100%; padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 13px;" placeholder="Tuliskan catatan revisi atau evaluasi Anda di sini..."></textarea>
                                <x-form-error name="supervisor_note" />
                            </div>
                            
                            <div style="display: flex; gap: 12px;">
                                <button type="submit" name="action" value="approve" class="btn-primary" style="background: #166534;">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">check_circle</span> Setujui Logbook
                                </button>
                                <button type="submit" name="action" value="reject" class="btn-secondary" style="color: #991b1b; border-color: #991b1b; background: #fef2f2;">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">assignment_return</span> Kembalikan untuk Revisi
                                </button>
                            </div>
                        </form>
                    @elseif($logbook->supervisor_note)
                        <div style="margin-top: 16px; padding: 12px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <p class="text-label-sm" style="color: #424751; font-weight: 600; margin-bottom: 4px;">Catatan Dosen:</p>
                            <p class="text-body-sm" style="color: #191c20; margin: 0;">{{ $logbook->supervisor_note }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
