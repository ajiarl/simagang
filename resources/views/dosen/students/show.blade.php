@extends('layouts.app')

@section('title', 'Detail Bimbingan Mahasiswa')
@section('page-title', 'Detail Mahasiswa Bimbingan')

@section('content')
<div style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
    <div>
        <h2 class="text-display-sm" style="color: #191c20; margin-bottom: 4px;">{{ $application->user->name }}</h2>
        <p class="text-body-sm" style="color: #424751;">NIM: {{ $application->user->nim ?? '-' }} &bull; {{ $application->internshipPeriod->name }}</p>
    </div>
    <a href="{{ route('dosen.students.index') }}" class="btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); lg:grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; align-items: start;">
    {{-- Left Side: Info and Assessment --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{-- Profile/Internship Info --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span class="material-symbols-outlined" style="color: #003e7e;">info</span> Informasi Magang
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Mitra Industri</p>
                        <p class="text-body-sm" style="color: #191c20; font-weight: 600;">{{ $application->company->name }}</p>
                    </div>
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Status Magang</p>
                        @if($application->status === 'completed')
                            <span class="chip-approved" style="padding: 4px 10px; font-size: 11px;">Selesai Magang</span>
                        @else
                            <span class="chip-pending" style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; font-size: 11px;">Aktif Magang</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Tanggal Mulai</p>
                        <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $application->start_date ? $application->start_date->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-label-sm" style="color: #737782; margin-bottom: 4px;">Tanggal Selesai</p>
                        <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $application->end_date ? $application->end_date->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Assessment Card --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span class="material-symbols-outlined" style="color: #003e7e;">grade</span> Penilaian Magang
                </h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    {{-- Dosen Assessment --}}
                    <div style="padding: 16px; border: 1px solid #c2c6d3; border-radius: 8px; background: #ffffff;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span class="text-body-sm" style="font-weight: 600; color: #191c20;">Evaluasi Dosen Pembimbing</span>
                            @if($dosenAssessment)
                                <span class="chip-approved" style="font-weight: bold; font-size: 14px; padding: 4px 12px;">{{ $dosenAssessment->final_score }}</span>
                            @else
                                <span class="chip-pending" style="font-size: 11px; padding: 4px 10px;">Belum Dinilai</span>
                            @endif
                        </div>
                        @if($dosenAssessment)
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 4px; margin-bottom: 8px; text-align: center;">
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Disiplin</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $dosenAssessment->discipline }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Sikap</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $dosenAssessment->attitude }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Keahlian</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $dosenAssessment->skills }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Komunikasi</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $dosenAssessment->communication }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Inisiatif</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $dosenAssessment->initiative }}</p>
                                </div>
                            </div>
                            @if($dosenAssessment->notes)
                                <p class="text-body-sm" style="color: #424751; font-style: italic; background: #f9f9ff; padding: 8px; border-radius: 4px;">
                                    "{{ $dosenAssessment->notes }}"
                                </p>
                            @endif
                        @else
                            <div style="text-align: right; margin-top: 12px;">
                                <a href="{{ route('dosen.assessments.index') }}" class="btn-primary" style="padding: 6px 12px; font-size: 12px; text-decoration: none;">
                                    Beri Penilaian Dosen
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Company Assessment --}}
                    <div style="padding: 16px; border: 1px solid #c2c6d3; border-radius: 8px; background: #ffffff;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span class="text-body-sm" style="font-weight: 600; color: #191c20;">Evaluasi Pembimbing Lapangan (Mitra)</span>
                            @if($companyAssessment)
                                <span class="chip-approved" style="font-weight: bold; font-size: 14px; padding: 4px 12px;">{{ $companyAssessment->final_score }}</span>
                            @else
                                <span class="chip-pending" style="font-size: 11px; padding: 4px 10px;">Belum Dinilai</span>
                            @endif
                        </div>
                        @if($companyAssessment)
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 4px; margin-bottom: 8px; text-align: center;">
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Disiplin</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $companyAssessment->discipline }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Sikap</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $companyAssessment->attitude }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Keahlian</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $companyAssessment->skills }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Komunikasi</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $companyAssessment->communication }}</p>
                                </div>
                                <div style="background: #f3f3fa; padding: 4px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #737782;">Inisiatif</p>
                                    <p style="font-size: 12px; font-weight: 600; color: #191c20;">{{ $companyAssessment->initiative }}</p>
                                </div>
                            </div>
                            @if($companyAssessment->notes)
                                <p class="text-body-sm" style="color: #424751; font-style: italic; background: #f9f9ff; padding: 8px; border-radius: 4px;">
                                    "{{ $companyAssessment->notes }}"
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side: Logbooks and Attendances --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{-- Logbook Summary --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span class="material-symbols-outlined" style="color: #003e7e;">menu_book</span> Aktivitas Logbook
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px; margin-bottom: 20px;">
                    <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e2e9; text-align: center;">
                        <p class="text-label-sm" style="color: #737782;">Total</p>
                        <p class="text-headline-md" style="color: #191c20; font-weight: bold; margin-top: 4px;">{{ $totalLogbook }}</p>
                    </div>
                    <div style="background: #ecfdf5; padding: 12px; border-radius: 8px; border: 1px solid #a7f3d0; text-align: center;">
                        <p class="text-label-sm" style="color: #047857;">Disetujui</p>
                        <p class="text-headline-md" style="color: #047857; font-weight: bold; margin-top: 4px;">{{ $approvedLogbook }}</p>
                    </div>
                    <div style="background: #fef9c3; padding: 12px; border-radius: 8px; border: 1px solid #fef08a; text-align: center;">
                        <p class="text-label-sm" style="color: #a16207;">Menunggu</p>
                        <p class="text-headline-md" style="color: #a16207; font-weight: bold; margin-top: 4px;">{{ $pendingLogbook }}</p>
                    </div>
                    <div style="background: #fef2f2; padding: 12px; border-radius: 8px; border: 1px solid #fecaca; text-align: center;">
                        <p class="text-label-sm" style="color: #b91c1c;">Revisi</p>
                        <p class="text-headline-md" style="color: #b91c1c; font-weight: bold; margin-top: 4px;">{{ $rejectedLogbook }}</p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                @php
                    $logbookPercent = $totalLogbook > 0 ? round(($approvedLogbook / $totalLogbook) * 100) : 0;
                @endphp
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span class="text-label-sm" style="color: #424751;">Tingkat Persetujuan Logbook</span>
                        <span class="text-label-sm" style="color: #191c20; font-weight: 600;">{{ $logbookPercent }}%</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e2e2e9; border-radius: 9999px; overflow: hidden;">
                        <div style="width: {{ $logbookPercent }}%; height: 100%; background: #0058be; border-radius: 9999px;"></div>
                    </div>
                </div>

                <div style="text-align: right;">
                    <a href="{{ route('dosen.logbooks.student', $application->id) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">fact_check</span> Tinjau Logbook
                    </a>
                </div>
            </div>
        </div>

        {{-- Attendance Summary --}}
        <div class="card">
            <div class="card-body">
                <h3 class="text-headline-sm" style="color: #191c20; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span class="material-symbols-outlined" style="color: #003e7e;">event_available</span> Kehadiran / Presensi
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin-bottom: 20px;">
                    <div style="background: #f8fafc; padding: 10px; border-radius: 6px; border: 1px solid #e2e2e9; text-align: center;">
                        <p style="font-size: 11px; color: #737782;">Total QR</p>
                        <p style="font-size: 16px; font-weight: bold; color: #191c20; margin-top: 2px;">{{ $totalAttendance }}</p>
                    </div>
                    <div style="background: #ecfdf5; padding: 10px; border-radius: 6px; border: 1px solid #a7f3d0; text-align: center;">
                        <p style="font-size: 11px; color: #047857;">Hadir (Terverifikasi)</p>
                        <p style="font-size: 16px; font-weight: bold; color: #047857; margin-top: 2px;">{{ $verifiedCount }}</p>
                    </div>
                    <div style="background: #fef9c3; padding: 10px; border-radius: 6px; border: 1px solid #fef08a; text-align: center;">
                        <p style="font-size: 11px; color: #a16207;">Belum Diverifikasi</p>
                        <p style="font-size: 16px; font-weight: bold; color: #a16207; margin-top: 2px;">{{ $pendingCount }}</p>
                    </div>
                </div>

                {{-- Attendance Rate --}}
                @php
                    $attendancePercent = $totalAttendance > 0 ? round(($verifiedCount / $totalAttendance) * 100) : 0;
                @endphp
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span class="text-label-sm" style="color: #424751;">Persentase Kehadiran</span>
                        <span class="text-label-sm" style="color: #191c20; font-weight: 600;">{{ $attendancePercent }}%</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e2e2e9; border-radius: 9999px; overflow: hidden;">
                        <div style="width: {{ $attendancePercent }}%; height: 100%; background: #10b981; border-radius: 9999px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
