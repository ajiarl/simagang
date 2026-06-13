@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.students.index') }}" class="text-blue-700 hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar
    </a>
    <a href="{{ route('admin.students.edit', $student) }}" class="btn-primary">
        Edit Data
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="card">
            <div class="p-6 text-center border-b border-gray-200">
                <div class="w-24 h-24 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                    {{ $student->initials }}
                </div>
                <h3 class="text-headline-sm text-gray-900">{{ $student->name }}</h3>
                <p class="text-body-sm text-gray-500">{{ $student->nim ?? 'NIM belum diatur' }}</p>
            </div>
            <div class="p-6 flex flex-col gap-4">
                <div>
                    <p class="text-label-sm text-gray-500 mb-1">Email</p>
                    <p class="text-body-sm text-gray-900">{{ $student->email }}</p>
                </div>
                <div>
                    <p class="text-label-sm text-gray-500 mb-1">Telepon</p>
                    <p class="text-body-sm text-gray-900">{{ $student->phone ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="card">
            <div class="p-5 border-b border-gray-200">
                <h3 class="text-headline-sm text-gray-900">Riwayat Pengajuan Magang</h3>
            </div>
            <div class="p-0">
                @if($student->internshipApplications->isEmpty())
                    <p class="text-body-sm text-gray-500 text-center p-6">Belum ada pengajuan magang.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">Perusahaan</th>
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">Periode</th>
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">Status</th>
                                    <th class="text-label-md p-4 text-left border-b border-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->internshipApplications as $app)
                                <tr>
                                    <td class="text-body-sm p-4 border-b border-gray-200">{{ $app->company->name ?? '-' }}</td>
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
                                        <a href="{{ route('admin.applications.show', $app) }}" class="text-blue-700 hover:underline">Lihat Detail</a>
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
