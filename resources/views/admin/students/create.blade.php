@extends('layouts.app')

@section('title', 'Tambah Mahasiswa Baru')
@section('page-title', 'Tambah Mahasiswa')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.students.index') }}" class="text-blue-700 hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar
    </a>
</div>

<div class="card max-w-2xl">
    <div class="p-5 border-b border-gray-200">
        <h3 class="text-headline-sm text-gray-900">Form Tambah Mahasiswa</h3>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('admin.students.store') }}" class="flex flex-col gap-6">
            @csrf
            
            <div class="flex flex-col gap-2">
                <label for="nim" class="text-label-md text-gray-700">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ old('nim') }}" class="form-input w-full p-3" placeholder="Masukkan NIM (opsional)">
                <x-form-error name="nim" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="name" class="text-label-md text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input w-full p-3" placeholder="Masukkan Nama Lengkap">
                <x-form-error name="name" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="email" class="text-label-md text-gray-700">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input w-full p-3" placeholder="email@contoh.com">
                <x-form-error name="email" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="phone" class="text-label-md text-gray-700">No. Telepon (Opsional)</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-input w-full p-3" placeholder="Contoh: 08123456789">
                <x-form-error name="phone" />
            </div>
            
            <hr class="border-gray-200 my-2">
            <h4 class="text-label-md text-gray-900">Keamanan</h4>
            
            <div class="flex flex-col gap-2">
                <label for="password" class="text-label-md text-gray-700">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password" required class="form-input w-full p-3" placeholder="Minimal 8 karakter">
                <x-form-error name="password" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password_confirmation" class="text-label-md text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="form-input w-full p-3" placeholder="Ketik ulang password">
                <x-form-error name="password_confirmation" />
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('admin.students.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined text-sm">save</span> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
