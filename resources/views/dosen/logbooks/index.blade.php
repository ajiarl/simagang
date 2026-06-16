@extends('layouts.app')

@section('title', 'Logbook Mahasiswa Bimbingan')
@section('page-title', 'Review Logbook')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
        <h3 class="text-headline-sm" style="color: #191c20;">Daftar Mahasiswa Bimbingan</h3>
        <p class="text-body-sm" style="color: #737782; margin-top: 4px;">Pilih mahasiswa untuk meninjau aktivitas harian (logbook) mereka.</p>
    </div>

    <div style="overflow-x: auto;">
        @if($applications->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <p class="text-body-md" style="color: #737782;">Belum ada mahasiswa bimbingan yang aktif.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Perusahaan Magang</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: center; border-bottom: 1px solid #c2c6d3;">Logbook Menunggu Review</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: right; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td style="padding: 16px 20px;">
                            <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $app->user->name }}</p>
                            <p class="text-label-sm" style="color: #737782;">{{ $app->user->nim }}</p>
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                            {{ $app->company->name }}
                        </td>
                        <td style="padding: 16px 20px; text-align: center;">
                            @if($app->logbooks->count() > 0)
                                <span style="display: inline-block; padding: 4px 12px; background: #fee2e2; color: #991b1b; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    {{ $app->logbooks->count() }} Menunggu
                                </span>
                            @else
                                <span style="color: #737782; font-size: 13px;">Semua sudah direview</span>
                            @endif
                        </td>
                        <td style="padding: 16px 20px; text-align: right;">
                            <a href="{{ route('dosen.logbooks.student', $app->id) }}" class="btn-primary" style="padding: 6px 12px; font-size: 13px; text-decoration: none;">
                                Tinjau Logbook
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
