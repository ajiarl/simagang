@extends('layouts.app')

@section('title', 'Edit Perusahaan')
@section('page-title', 'Edit Perusahaan Mitra')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.companies.index') }}" class="text-blue-700 hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar
    </a>
</div>

<div class="card max-w-2xl">
    <div class="p-5 border-b border-gray-200">
        <h3 class="text-headline-sm text-gray-900">Edit Data Perusahaan</h3>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('admin.companies.update', $company) }}" class="flex flex-col gap-5">
            @csrf
            @method('PUT')
            
            <div class="flex flex-col gap-2">
                <label for="name" class="text-label-md text-gray-700">Nama Perusahaan *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}" required class="form-input w-full p-3">
                <x-form-error name="name" />
                <x-form-error name="name" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-label-md text-gray-700">Email Perusahaan *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $company->email) }}" required class="form-input w-full p-3">
                        <x-form-error name="email" />
                        <x-form-error name="email" />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="phone" class="text-label-md text-gray-700">Telepon *</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $company->phone) }}" required class="form-input w-full p-3">
                        <x-form-error name="phone" />
                        <x-form-error name="phone" />
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="contact_person" class="text-label-md text-gray-700">Contact Person (Nama Lengkap) *</label>
                <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person', $company->contact_person) }}" required class="form-input w-full p-3">
                <x-form-error name="contact_person" />
                <x-form-error name="contact_person" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="website" class="text-label-md text-gray-700">Website</label>
                <input type="url" id="website" name="website" value="{{ old('website', $company->website) }}" placeholder="https://" class="form-input w-full p-3">
                <x-form-error name="website" />
                <x-form-error name="website" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="address" class="text-label-md text-gray-700">Alamat Lengkap *</label>
                <textarea id="address" name="address" rows="3" required class="form-input w-full p-3">{{ old('address', $company->address) }}</textarea>
                <x-form-error name="address" />
                <x-form-error name="address" />
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('admin.companies.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
