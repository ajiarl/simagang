@extends('layouts.app')

@section('title', 'Edit Logbook Harian')
@section('page-title', 'Logbook')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
        <h3 class="text-headline-sm" style="color: #191c20;">Edit Logbook</h3>
        <div style="margin-top: 8px;">
            @if($logbook->status === 'rejected')
                <span class="chip-rejected">Revisi Diperlukan</span>
            @else
                <span class="chip-pending" style="background: #ededf4; color: #424751;">Draft</span>
            @endif
        </div>
    </div>
    
    @if($logbook->supervisor_note)
        <div style="padding: 16px 20px; background: #fee2e2; border-bottom: 1px solid #fecaca;">
            <p class="text-label-sm" style="color: #991b1b; font-weight: 600; margin-bottom: 4px;">Catatan Dosen Pembimbing:</p>
            <p class="text-body-sm" style="color: #991b1b; margin: 0;">{{ $logbook->supervisor_note }}</p>
        </div>
    @endif

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

        <form action="{{ route('mahasiswa.logbooks.update', $logbook) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Tanggal --}}
            <div style="margin-bottom: 20px;">
                <label for="date" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Tanggal Kegiatan *</label>
                <input type="date" name="date" id="date" max="{{ date('Y-m-d') }}" value="{{ old('date', $logbook->date->format('Y-m-d')) }}" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20;" required>
                <x-form-error name="date" />
            </div>

            {{-- Kegiatan --}}
            <div style="margin-bottom: 20px;">
                <label for="activity" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Kegiatan yang dilakukan *</label>
                <textarea name="activity" id="activity" rows="4" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20; resize: vertical;" required>{{ old('activity', $logbook->activity) }}</textarea>
                <x-form-error name="activity" />
            </div>

            {{-- Pembelajaran --}}
            <div style="margin-bottom: 24px;">
                <label for="learning" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Pembelajaran / Insight (Opsional)</label>
                <textarea name="learning" id="learning" rows="3" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20; resize: vertical;">{{ old('learning', $logbook->learning) }}</textarea>
                <x-form-error name="learning" />
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #c2c6d3; padding-top: 20px; flex-wrap: wrap;">
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
