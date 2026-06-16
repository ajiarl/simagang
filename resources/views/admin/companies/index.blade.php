@extends('layouts.app')

@section('title', 'Manajemen Perusahaan')
@section('page-title', 'Daftar Perusahaan Mitra')

@section('content')
{{-- Page Header --}}
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <h2 class="text-display-lg" style="color: #191c20;">Perusahaan Mitra</h2>
    <a href="{{ route('admin.companies.create') }}" class="btn-primary" style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Tambah Perusahaan
    </a>
</div>

{{-- Search Card --}}
<div class="card" style="margin-bottom: 16px;">
    <div style="padding: 16px 20px;">
        <form method="GET" action="{{ route('admin.companies.index') }}" style="display: flex; gap: 8px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari perusahaan berdasarkan nama, email, atau telepon..." class="form-input" style="flex: 1; min-width: 100%; max-width: 300px;">
            <button type="submit" class="btn-primary">
                <span class="material-symbols-outlined" style="font-size: 18px;">search</span> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.companies.index') }}" class="btn-secondary" style="text-decoration: none;">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="card">
    <div style="overflow-x: auto;">
        @if($companies->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #c2c6d3; display: block; margin-bottom: 12px;">business</span>
                <p class="text-body-md" style="color: #737782;">Tidak ada data perusahaan ditemukan.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Nama Perusahaan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Industri</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Kontak</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa Aktif</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: center; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                    <tr style="border-bottom: 1px solid #e2e2e9;">
                        <td style="padding: 16px 20px;">
                            <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $company->name }}</p>
                            <p class="text-label-sm" style="color: #737782;">{{ $company->email }}</p>
                        </td>
                        <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                            {{ $company->industry ?? '-' }}
                        </td>
                        <td style="padding: 16px 20px;">
                            <p class="text-body-sm" style="color: #191c20;">{{ $company->contact_person }}</p>
                            <p class="text-label-sm" style="color: #737782;">{{ $company->phone }}</p>
                        </td>
                        <td style="padding: 16px 20px;">
                            @if($company->active_internships > 0)
                                <span class="chip-approved">{{ $company->active_internships }} Mahasiswa</span>
                            @else
                                <span class="text-body-sm" style="color: #737782;">-</span>
                            @endif
                        </td>
                        <td style="padding: 16px 20px;">
                            <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                                <a href="{{ route('admin.companies.show', $company) }}" class="btn-secondary" style="padding: 10px 14px; font-size: 13px; text-decoration: none;">
                                    Detail
                                </a>
                                <a href="{{ route('admin.companies.edit', $company) }}" class="text-label-md" style="color: #0058be; text-decoration: none; padding: 6px 8px;">
                                    Edit
                                </a>
                                <button onclick="confirmDelete('{{ route('admin.companies.destroy', $company) }}')" class="text-label-md" style="color: #ba1a1a; background: none; border: none; cursor: pointer; padding: 6px 8px;">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
</div>
        @endif
    </div>
    @if($companies->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3;">
            {{ $companies->links() }}
        </div>
    @endif
</div>
@endsection
