@extends('layouts.app')

@section('title', 'Mahasiswa Bimbingan')
@section('page-title', 'Mahasiswa Bimbingan')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
        <h3 class="text-headline-sm" style="color: #191c20;">Daftar Mahasiswa Bimbingan</h3>
        <p class="text-body-sm" style="color: #737782; margin-top: 4px;">Pantau progress kegiatan dan evaluasi penilaian mahasiswa bimbingan Anda.</p>
    </div>

    <div style="overflow-x: auto;">
        @if($applications->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <p class="text-body-md" style="color: #737782;">Belum ada mahasiswa bimbingan yang terdaftar.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">No.</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan Magang</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Periode</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: center; border-bottom: 1px solid #c2c6d3;">Status</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: right; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $index => $app)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751; width: 40px;">
                            {{ $index + 1 }}
                        </td>
                        <td style="padding: 16px 20px;">
                            <p class="text-body-sm" style="color: #191c20; font-weight: 600; margin-bottom: 2px;">{{ $app->user->name }}</p>
                            <p class="text-label-sm" style="color: #737782;">NIM: {{ $app->user->nim ?? '-' }}</p>
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #191c20;">
                            {{ $app->company->name }}
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                            {{ $app->internshipPeriod->name }}
                        </td>
                        <td style="padding: 16px 20px; text-align: center;">
                            @if($app->status === 'completed')
                                <span class="chip-approved" style="padding: 4px 10px; font-size: 11px;">Selesai Magang</span>
                            @else
                                <span class="chip-pending" style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; font-size: 11px;">Aktif Magang</span>
                            @endif
                        </td>
                        <td style="padding: 16px 20px; text-align: right;">
                            <a href="{{ route('dosen.students.show', $app) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                <span class="material-symbols-outlined" style="font-size: 16px;">visibility</span> Detail
                            </a>
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
