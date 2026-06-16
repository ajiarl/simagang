@extends('layouts.app')

@section('title', 'Manajemen Dosen Pembimbing')
@section('page-title', 'Manajemen Dosen')

@section('content')
<style>
    @media (max-width: 767px) {
        .col-fakultas, .col-aksi { display: none; }
    }
</style>

{{-- Page Header --}}
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <h2 class="text-display-lg" style="color: #191c20;">Manajemen Dosen Pembimbing</h2>
    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <a href="{{ route('admin.lecturers.create') }}" class="btn-primary" style="text-decoration: none; padding: 8px 16px;">
            <span class="material-symbols-outlined" style="font-size: 18px; margin-right: 4px;">add</span> Tambah Dosen
        </a>
    </div>
</div>

{{-- Search Card --}}
<div class="card" style="margin-bottom: 16px;">
    <div style="padding: 16px 20px;">
        <form method="GET" action="{{ route('admin.lecturers.index') }}" style="display: flex; gap: 8px; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau fakultas..." class="form-input" style="flex: 1;">
            <button type="submit" class="btn-primary">
                <span class="material-symbols-outlined" style="font-size: 18px;">search</span> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.lecturers.index') }}" class="btn-secondary" style="text-decoration: none;">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="card">
    <div style="overflow-x: auto;">
        @if($lecturers->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #c2c6d3; display: block; margin-bottom: 12px;">person_search</span>
                <p class="text-body-md" style="color: #737782;">Tidak ada data dosen pembimbing ditemukan.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3; width: 48px;">No.</th>
                            <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Dosen Pembimbing</th>
                            <th class="text-label-md col-fakultas" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Fakultas / Departemen</th>
                            <th class="text-label-md col-aksi" style="color: #424751; padding: 12px 20px; text-align: center; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lecturers as $dosen)
                        <tr style="border-bottom: 1px solid #e2e2e9;">
                            <td class="text-body-sm" style="padding: 16px 20px; color: #737782;">{{ $loop->iteration + ($lecturers->currentPage() - 1) * $lecturers->perPage() }}</td>
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $dosen->name }}</p>
                                <p class="text-label-sm" style="color: #737782;">{{ $dosen->email }}</p>
                                @if($dosen->phone)
                                    <p class="text-label-sm" style="color: #737782;">{{ $dosen->phone }}</p>
                                @endif
                            </td>
                            <td class="col-fakultas" style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #191c20;">{{ $dosen->faculty ?? '-' }}</p>
                                <p class="text-label-sm" style="color: #737782;">{{ $dosen->department ?? '-' }}</p>
                            </td>
                            <td class="col-aksi" style="padding: 16px 20px;">
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    <a href="{{ route('admin.lecturers.edit', $dosen) }}" class="text-label-md" style="color: #0058be; text-decoration: none; padding: 6px 8px; display: inline-flex; align-items: center;">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @if($lecturers->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3;">
            {{ $lecturers->links() }}
        </div>
    @endif
</div>
@endsection
