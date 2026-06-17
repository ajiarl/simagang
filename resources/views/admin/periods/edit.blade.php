@extends('layouts.app')

@section('title', 'Edit Periode Magang')
@section('page-title', 'Edit Periode Magang')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.periods.index') }}" class="text-blue-700 hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar
    </a>
</div>

<div class="card max-w-2xl">
    <div class="p-5 border-b border-gray-200">
        <h3 class="text-headline-sm text-gray-900">Form Edit Periode</h3>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('admin.periods.update', $period) }}" class="flex flex-col gap-5">
            @csrf
            @method('PATCH')
            
            <div class="flex flex-col gap-2">
                <label for="name" class="text-label-md text-gray-700">Nama Periode *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $period->name) }}" required class="form-input w-full p-3">
                <x-form-error name="name" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex flex-col gap-2">
                    <label for="registration_start" class="text-label-md text-gray-700">Tanggal Buka Pendaftaran *</label>
                    <input type="text" id="registration_start" name="registration_start" value="{{ old('registration_start', optional($period->registration_start)->format('Y-m-d')) }}" required class="form-input w-full p-3">
                    <x-form-error name="registration_start" />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="registration_end" class="text-label-md text-gray-700">Tanggal Tutup Pendaftaran *</label>
                    <input type="text" id="registration_end" name="registration_end" value="{{ old('registration_end', optional($period->registration_end)->format('Y-m-d')) }}" required class="form-input w-full p-3">
                    <x-form-error name="registration_end" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex flex-col gap-2">
                    <label for="start_date" class="text-label-md text-gray-700">Tanggal Mulai Magang *</label>
                    <input type="text" id="start_date" name="start_date" value="{{ old('start_date', optional($period->start_date)->format('Y-m-d')) }}" required class="form-input w-full p-3">
                    <x-form-error name="start_date" />
                </div>

                <div class="flex flex-col gap-2">
                    <label for="end_date" class="text-label-md text-gray-700">Tanggal Selesai Magang *</label>
                    <input type="text" id="end_date" name="end_date" value="{{ old('end_date', optional($period->end_date)->format('Y-m-d')) }}" required class="form-input w-full p-3">
                    <x-form-error name="end_date" />
                </div>
            </div>

            <div class="mt-2 flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $period->is_active) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <label for="is_active" class="text-body-md text-gray-900 cursor-pointer">Jadikan Periode Aktif (Hanya 1 yang bisa aktif)</label>
            </div>
            <x-form-error name="is_active" />

            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('admin.periods.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const regStartVal = document.getElementById("registration_start").value;
        const regEndVal = document.getElementById("registration_end").value;
        const startVal = document.getElementById("start_date").value;

        const fpRegStart = flatpickr("#registration_start", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr) {
                fpRegEnd.set('minDate', dateStr);
            }
        });

        const fpRegEnd = flatpickr("#registration_end", {
            dateFormat: "Y-m-d",
            minDate: regStartVal || false,
            onChange: function(selectedDates, dateStr) {
                fpStartDate.set('minDate', dateStr);
            }
        });

        const fpStartDate = flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            minDate: regEndVal || false,
            onChange: function(selectedDates, dateStr) {
                fpEndDate.set('minDate', dateStr);
            }
        });

        const fpEndDate = flatpickr("#end_date", {
            dateFormat: "Y-m-d",
            minDate: startVal || false
        });
    });
</script>
@endpush
