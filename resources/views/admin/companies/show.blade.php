@extends('layouts.app')

@section('title', 'Detail Perusahaan')
@section('page-title', 'Detail Perusahaan Mitra')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.companies.index') }}" class="text-blue-700 hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar
    </a>
    <a href="{{ route('admin.companies.edit', $company) }}" class="btn-primary">
        Edit Data
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="card">
            <div class="p-6 text-center border-b border-gray-200">
                <div class="w-24 h-24 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center text-3xl mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">business</span>
                </div>
                <h3 class="text-headline-sm text-gray-900">{{ $company->name }}</h3>
                <p class="text-body-sm text-gray-500">{{ $company->website ?? 'Website belum diatur' }}</p>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div>
                    <p class="text-label-sm text-gray-500 mb-1">Email</p>
                    <p class="text-body-sm text-gray-900">{{ $company->email }}</p>
                </div>
                <div>
                    <p class="text-label-sm text-gray-500 mb-1">Telepon</p>
                    <p class="text-body-sm text-gray-900">{{ $company->phone }}</p>
                </div>
                <div>
                    <p class="text-label-sm text-gray-500 mb-1">Contact Person</p>
                    <p class="text-body-sm text-gray-900">{{ $company->contact_person }}</p>
                </div>
                <div>
                    <p class="text-label-sm text-gray-500 mb-1">Alamat</p>
                    <p class="text-body-sm text-gray-900">{{ $company->address }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="card">
            <div class="p-5 border-b border-gray-200">
                <h3 class="text-headline-sm text-gray-900">Mahasiswa Magang (Terbaru)</h3>
            </div>
            <div class="p-0">
                @if($company->internshipApplications->isEmpty())
                    <p class="text-body-sm text-gray-500 text-center p-6">Belum ada mahasiswa yang mengajukan magang di perusahaan ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">NIM / Nama</th>
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">Periode</th>
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">Status</th>
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company->internshipApplications as $app)
                                <tr>
                                    <td class="text-body-sm p-4 border-b border-gray-200">
                                        <strong>{{ $app->user->name ?? '-' }}</strong><br>
                                        <span class="text-gray-500">{{ $app->user->nim ?? '-' }}</span>
                                    </td>
                                    <td class="text-body-sm p-4 border-b border-gray-200">{{ $app->internshipPeriod->name ?? '-' }}</td>
                                    <td class="text-body-sm p-4 border-b border-gray-200">
                                        @if($app->status === 'approved')
                                            <span class="chip-approved">Diterima</span>
                                        @elseif($app->status === 'rejected')
                                            <span class="chip-rejected">Ditolak</span>
                                        @else
                                            <span class="chip-pending">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="text-body-sm p-4 border-b border-gray-200">
                                        <a href="{{ route('admin.applications.show', $app) }}" class="text-blue-700 hover:underline">Lihat Pengajuan</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
