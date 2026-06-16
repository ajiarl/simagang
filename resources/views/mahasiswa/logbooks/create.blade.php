@extends('layouts.app')

@section('title', 'Isi Logbook Harian')
@section('page-title', 'Logbook')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
        <h3 class="text-headline-sm" style="color: #191c20;">Formulir Logbook</h3>
        <p class="text-body-sm" style="color: #737782; margin-top: 4px;">Catat kegiatan yang Anda lakukan hari ini.</p>
    </div>
    <div style="padding: 24px;">
        @if($errors->any())
            <div style="margin-bottom: 24px; padding: 16px; background: #fee2e2; border-radius: 8px; color: #991b1b; font-size: 14px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.logbooks.store') }}" method="POST">
            @csrf

            {{-- Tanggal --}}
            <div style="margin-bottom: 20px;">
                <label for="date" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Tanggal Kegiatan *</label>
                <input type="date" name="date" id="date" max="{{ date('Y-m-d') }}" value="{{ old('date', date('Y-m-d')) }}" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20;" required>
                <x-form-error name="date" />
            </div>

            {{-- Kegiatan --}}
            <div style="margin-bottom: 20px;">
                <label for="activity" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Kegiatan yang dilakukan *</label>
                <textarea name="activity" id="activity" rows="4" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20; resize: vertical;" required placeholder="Deskripsikan pekerjaan, tugas, atau aktivitas yang Anda kerjakan...">{{ old('activity') }}</textarea>
                <x-form-error name="activity" />
            </div>

            {{-- Pembelajaran --}}
            <div style="margin-bottom: 24px;">
                <label for="learning" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Pembelajaran / Insight (Opsional)</label>
                <textarea name="learning" id="learning" rows="3" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20; resize: vertical;" placeholder="Apa hal baru yang Anda pelajari hari ini?">{{ old('learning') }}</textarea>
                <x-form-error name="learning" />
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #c2c6d3; padding-top: 20px;; flex-wrap: wrap;">
                <a href="{{ route('mahasiswa.logbooks.index') }}" class="btn-secondary" style="text-decoration: none;">Batal</a>
                
                <button type="submit" name="action" value="draft" class="btn-secondary" style="background: #f8fafc;">
                    Simpan Draft
                </button>

                <button type="submit" name="action" value="submit" class="btn-primary">
                    <span class="material-symbols-outlined" style="font-size: 18px;">send</span> Submit ke Dosen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
