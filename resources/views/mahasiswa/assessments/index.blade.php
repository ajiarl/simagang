@extends('layouts.app')

@section('title', 'Rapor Penilaian')
@section('page-title', 'Rapor Penilaian Magang')

@section('content')

@if(!$hasApplication)
<div class="card" style="padding: 40px 20px; text-align: center;">
    <span class="material-symbols-outlined" style="font-size: 48px; color: #737782; margin-bottom: 16px;">sentiment_dissatisfied</span>
    <p class="text-body-md" style="color: #424751; margin-bottom: 8px;">Anda belum memiliki pengajuan magang yang disetujui.</p>
    <p class="text-body-sm" style="color: #737782;">Penilaian magang hanya tersedia jika status magang Anda sudah disetujui.</p>
</div>
@else

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; max-width: 1000px; margin: 0 auto;">
    
    {{-- Card 3: Final Combined Score --}}
    <div class="card" style="text-align: center; padding: 32px 20px; background: linear-gradient(135deg, #003e7e 0%, #0058be 100%); color: white;">
        <h2 class="text-headline-sm" style="margin-bottom: 8px; color: rgba(255,255,255,0.9);">Nilai Akhir Magang</h2>
        @if($combinedScore)
            <div style="font-size: 64px; font-weight: 800; line-height: 1; margin: 16px 0;">
                {{ $combinedScore }}
            </div>
            <p style="color: rgba(255,255,255,0.8); font-size: 14px;">Gabungan (50% Dosen, 50% Perusahaan)</p>
        @else
            <div style="font-size: 24px; font-weight: 600; margin: 24px 0; color: rgba(255,255,255,0.7);">
                Menunggu Penilaian Lengkap
            </div>
            <p style="color: rgba(255,255,255,0.8); font-size: 14px;">
                Dosen: {!! $dosenAssessment ? '<span style="color: #4ade80;">Sudah</span>' : '<span style="color: #fca5a5;">Belum</span>' !!} &bull; 
                Perusahaan: {!! $perusahaanAssessment ? '<span style="color: #4ade80;">Sudah</span>' : '<span style="color: #fca5a5;">Belum</span>' !!}
            </p>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        @php
            $assessors = [
                ['title' => 'Dosen Pembimbing', 'icon' => 'school', 'data' => $dosenAssessment],
                ['title' => 'Perusahaan (Pembimbing Lapangan)', 'icon' => 'business', 'data' => $perusahaanAssessment],
            ];
        @endphp

        @foreach($assessors as $assessor)
            <div class="card" style="display: flex; flex-direction: column;">
                <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; align-items: center; gap: 12px;">
                    <span class="material-symbols-outlined" style="color: #0058be;">{{ $assessor['icon'] }}</span>
                    <h3 class="text-headline-sm" style="color: #191c20; margin: 0;">{{ $assessor['title'] }}</h3>
                </div>
                
                <div style="padding: 24px; flex: 1;">
                    @if(!$assessor['data'])
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #737782; text-align: center;">
                            <span class="material-symbols-outlined" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;">pending_actions</span>
                            <p class="text-body-md">Belum ada penilaian.</p>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                                <span class="text-body-md" style="color: #424751;">Kedisiplinan</span>
                                <span class="text-headline-sm" style="color: #191c20;">{{ $assessor['data']->discipline }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                                <span class="text-body-md" style="color: #424751;">Sikap & Perilaku</span>
                                <span class="text-headline-sm" style="color: #191c20;">{{ $assessor['data']->attitude }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                                <span class="text-body-md" style="color: #424751;">Kemampuan Teknis</span>
                                <span class="text-headline-sm" style="color: #191c20;">{{ $assessor['data']->skills }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                                <span class="text-body-md" style="color: #424751;">Komunikasi</span>
                                <span class="text-headline-sm" style="color: #191c20;">{{ $assessor['data']->communication }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                                <span class="text-body-md" style="color: #424751;">Inisiatif</span>
                                <span class="text-headline-sm" style="color: #191c20;">{{ $assessor['data']->initiative }}</span>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: #f8fafc; border-radius: 8px; margin-top: 8px;">
                                <span class="text-label-lg" style="color: #003e7e;">Total Rata-rata</span>
                                <span class="text-headline-md" style="color: #0058be;">{{ $assessor['data']->final_score }}</span>
                            </div>

                            @if($assessor['data']->notes)
                                <div style="margin-top: 16px; padding: 16px; background: #fdfdfd; border: 1px solid #e2e2e9; border-radius: 8px;">
                                    <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 8px;">Catatan Penilai:</span>
                                    <p class="text-body-sm" style="color: #424751; margin: 0; font-style: italic;">"{{ $assessor['data']->notes }}"</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>

@endif
@endsection
