@extends('layouts.app')

@section('title', 'Manajemen Mahasiswa')
@section('page-title', 'Manajemen Mahasiswa')

@section('content')
<style>
    @media (max-width: 767px) {
        .col-status, .col-aksi { display: none; }
    }
</style>

{{-- Page Header --}}
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <h2 class="text-display-lg" style="color: #191c20;">Manajemen Mahasiswa</h2>
    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <form action="{{ route('admin.students.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="status" class="form-input" style="width: auto; padding: 8px 12px; font-size: 14px; border-radius: 8px;" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif Magang</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Belum Magang</option>
            </select>
        </form>
        <a href="{{ route('admin.students.create') }}" class="btn-primary" style="text-decoration: none; padding: 8px 16px;">
            <span class="material-symbols-outlined" style="font-size: 18px; margin-right: 4px;">add</span> Tambah
        </a>
    </div>
</div>

{{-- Search Card --}}
<div class="card" style="margin-bottom: 16px;">
    <div style="padding: 16px 20px;">
        <form method="GET" action="{{ route('admin.students.index') }}" style="display: flex; gap: 8px; flex-wrap: wrap;">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, NIM, atau email..." class="form-input" style="flex: 1;">
            <button type="submit" class="btn-primary">
                <span class="material-symbols-outlined" style="font-size: 18px;">search</span> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.students.index', ['status' => request('status')]) }}" class="btn-secondary" style="text-decoration: none;">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="card">
    <div style="overflow-x: auto;">
        @if($students->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #c2c6d3; display: block; margin-bottom: 12px;">school</span>
                <p class="text-body-md" style="color: #737782;">Tidak ada data mahasiswa ditemukan.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3; width: 48px;">No.</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">NIM</th>
                        <th class="text-label-md col-status" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status Magang</th>
                        <th class="text-label-md col-aksi" style="color: #424751; padding: 12px 20px; text-align: center; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td class="text-body-sm" style="padding: 16px 20px; color: #737782;">{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                        <td style="padding: 16px 20px;">
                            <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $student->name }}</p>
                            <p class="text-label-sm" style="color: #737782;">{{ $student->email }}</p>
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">{{ $student->nim ?? '-' }}</td>
                        <td class="col-status" style="padding: 16px 20px;">
                            @if($student->active_internship > 0)
                                <span class="chip-approved">Aktif Magang</span>
                            @else
                                <span class="chip-pending">Belum Magang</span>
                            @endif
                        </td>
                        <td class="col-aksi" style="padding: 16px 20px;">
                            <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                <a href="{{ route('admin.students.show', $student) }}" class="btn-secondary" style="padding: 10px 14px; font-size: 13px; text-decoration: none;">
                                    Detail
                                </a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="text-label-md" style="color: #0058be; text-decoration: none; padding: 6px 8px; display: inline-flex; align-items: center;">
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
    @if($students->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3;">
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection
