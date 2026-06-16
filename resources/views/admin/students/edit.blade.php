@extends('layouts.app')

@section('title', 'Edit Mahasiswa')
@section('page-title', 'Edit Mahasiswa')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.students.index') }}" class="text-blue-700 hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar
    </a>
</div>

<div class="card max-w-2xl">
    <div class="p-5 border-b border-gray-200">
        <h3 class="text-headline-sm text-gray-900">Edit Data Mahasiswa</h3>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="flex flex-col gap-6">
            @csrf
            @method('PUT')
            
            <div class="flex flex-col gap-2">
                <label for="nim" class="text-label-md text-gray-700">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ old('nim', $student->nim) }}" class="form-input w-full p-3">
                <x-form-error name="nim" />
                <x-form-error name="nim" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="name" class="text-label-md text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required class="form-input w-full p-3">
                <x-form-error name="name" />
                <x-form-error name="name" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="email" class="text-label-md text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" required class="form-input w-full p-3">
                <x-form-error name="email" />
                <x-form-error name="email" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="phone" class="text-label-md text-gray-700">Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" class="form-input w-full p-3">
                <x-form-error name="phone" />
                <x-form-error name="phone" />
            </div>
            
            <hr class="border-gray-200 my-2">
            <h4 class="text-label-md text-gray-900">Ubah Password (Opsional)</h4>
            
            <div class="flex flex-col gap-2">
                <label for="password" class="text-label-md text-gray-700">Password Baru</label>
                <input type="password" id="password" name="password" class="form-input w-full p-3" placeholder="Kosongkan jika tidak ingin mengubah password">
                <x-form-error name="password" />
                <x-form-error name="password" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password_confirmation" class="text-label-md text-gray-700">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input w-full p-3">
                <x-form-error name="password_confirmation" />
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('admin.students.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
