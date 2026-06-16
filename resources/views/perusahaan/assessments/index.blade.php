@extends('layouts.app')

@section('title', 'Penilaian Mahasiswa Magang')
@section('page-title', 'Penilaian Mahasiswa Magang')

@section('content')
<div class="card" style="margin-bottom: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
        <h3 class="text-headline-sm" style="color: #191c20;">Daftar Mahasiswa</h3>
    </div>

    @if(session('success'))
        <div style="margin: 16px 20px; padding: 12px 16px; background: #dcfce7; border-radius: 8px; color: #166534; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="margin: 16px 20px; padding: 12px 16px; background: #fee2e2; border-radius: 8px; color: #991b1b; font-size: 14px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="margin: 16px 20px; padding: 16px; background: #fee2e2; border-radius: 8px; color: #991b1b; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="overflow-x: auto;">
        @if($applications->isEmpty())
            <div style="padding: 40px 20px; text-align: center;">
                <p class="text-body-md" style="color: #737782;">Belum ada mahasiswa magang aktif.</p>
            </div>
        @else
            <div style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch;">
<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Mahasiswa</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Jurusan</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Status Penilaian</th>
                        <th class="text-label-md" style="color: #424751; padding: 12px 20px; text-align: left; border-bottom: 1px solid #c2c6d3;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        @php
                            $assessment = $application->assessments->where('assessor_type', 'perusahaan')->first();
                        @endphp
                        <tr style="border-bottom: 1px solid #e2e2e9;">
                            <td style="padding: 16px 20px;">
                                <p class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $application->user->name }}</p>
                                <p class="text-label-sm" style="color: #737782;">{{ $application->user->nim }}</p>
                            </td>
                            <td class="text-body-sm" style="padding: 16px 20px; color: #424751;">
                                {{ $application->user->major ?? '-' }}
                            </td>
                            <td style="padding: 16px 20px;">
                                @if($assessment)
                                    <span class="chip-approved">Sudah Dinilai ({{ $assessment->final_score }})</span>
                                @else
                                    <span class="chip-pending">Belum Dinilai</span>
                                @endif
                            </td>
                            <td style="padding: 16px 20px;">
                                @if(!$assessment)
                                    <button onclick="document.getElementById('modal-{{ $application->id }}').style.display='flex'" class="btn-primary" style="padding: 6px 12px; font-size: 13px;">
                                        Input Nilai
                                    </button>
                                @else
                                    <button onclick="document.getElementById('modal-view-{{ $application->id }}').style.display='flex'" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">
                                        Lihat Nilai
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>
        @endif
    </div>
</div>

{{-- Modals --}}
@foreach($applications as $application)
    @php
        $assessment = $application->assessments->where('assessor_type', 'perusahaan')->first();
    @endphp

    @if(!$assessment)
        {{-- Modal Input Nilai --}}
        <div id="modal-{{ $application->id }}" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; align-items: center; justify-content: center;">
            <div class="card" style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; background: #fff; border-radius: 12px; margin: 20px;">
                <div style="padding: 20px; border-bottom: 1px solid #c2c6d3; display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="text-headline-sm">Input Penilaian: {{ $application->user->name }}</h3>
                    <button onclick="document.getElementById('modal-{{ $application->id }}').style.display='none'" style="background: none; border: none; cursor: pointer;">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <form action="{{ route('perusahaan.assessments.store', $application) }}" method="POST">
                    @csrf
                    <div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">
                        <p class="text-body-sm" style="color: #424751;">Berikan nilai 0 hingga 100 untuk masing-masing aspek kinerja magang:</p>
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                            <label for="discipline_{{ $application->id }}" class="text-label-md" style="flex: 1;">Kedisiplinan</label>
                            <input type="number" name="discipline" id="discipline_{{ $application->id }}" required min="0" max="100" style="width: 100px; padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px;" value="{{ old('discipline') }}">
                        </div>
                        <x-form-error name="discipline" />
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                            <label for="attitude_{{ $application->id }}" class="text-label-md" style="flex: 1;">Sikap & Perilaku</label>
                            <input type="number" name="attitude" id="attitude_{{ $application->id }}" required min="0" max="100" style="width: 100px; padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px;" value="{{ old('attitude') }}">
                        </div>
                        <x-form-error name="attitude" />
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                            <label for="skills_{{ $application->id }}" class="text-label-md" style="flex: 1;">Kemampuan Teknis</label>
                            <input type="number" name="skills" id="skills_{{ $application->id }}" required min="0" max="100" style="width: 100px; padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px;" value="{{ old('skills') }}">
                        </div>
                        <x-form-error name="skills" />

                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                            <label for="communication_{{ $application->id }}" class="text-label-md" style="flex: 1;">Komunikasi</label>
                            <input type="number" name="communication" id="communication_{{ $application->id }}" required min="0" max="100" style="width: 100px; padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px;" value="{{ old('communication') }}">
                        </div>
                        <x-form-error name="communication" />

                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                            <label for="initiative_{{ $application->id }}" class="text-label-md" style="flex: 1;">Inisiatif</label>
                            <input type="number" name="initiative" id="initiative_{{ $application->id }}" required min="0" max="100" style="width: 100px; padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px;" value="{{ old('initiative') }}">
                        </div>
                        <x-form-error name="initiative" />

                        <div>
                            <label for="notes_{{ $application->id }}" class="text-label-md" style="display: block; margin-bottom: 8px;">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" id="notes_{{ $application->id }}" rows="3" style="width: 100%; padding: 8px 12px; border: 1px solid #c2c6d3; border-radius: 6px;">{{ old('notes') }}</textarea>
                            <x-form-error name="notes" />
                        </div>
                    </div>
                    
                    <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3; display: flex; justify-content: flex-end; gap: 12px; background: #f8fafc; border-radius: 0 0 12px 12px; flex-wrap: wrap;">
                        <button type="button" onclick="document.getElementById('modal-{{ $application->id }}').style.display='none'" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-primary">Simpan Penilaian</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        {{-- Modal Lihat Nilai --}}
        <div id="modal-view-{{ $application->id }}" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; align-items: center; justify-content: center;">
            <div class="card" style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; background: #fff; border-radius: 12px; margin: 20px;">
                <div style="padding: 20px; border-bottom: 1px solid #c2c6d3; display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="text-headline-sm">Nilai: {{ $application->user->name }}</h3>
                    <button onclick="document.getElementById('modal-view-{{ $application->id }}').style.display='none'" style="background: none; border: none; cursor: pointer;">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <div style="padding: 20px; display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                        <span class="text-body-md" style="color: #424751;">Kedisiplinan</span>
                        <span class="text-headline-sm">{{ $assessment->discipline }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                        <span class="text-body-md" style="color: #424751;">Sikap & Perilaku</span>
                        <span class="text-headline-sm">{{ $assessment->attitude }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                        <span class="text-body-md" style="color: #424751;">Kemampuan Teknis</span>
                        <span class="text-headline-sm">{{ $assessment->skills }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                        <span class="text-body-md" style="color: #424751;">Komunikasi</span>
                        <span class="text-headline-sm">{{ $assessment->communication }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px solid #e2e2e9;">
                        <span class="text-body-md" style="color: #424751;">Inisiatif</span>
                        <span class="text-headline-sm">{{ $assessment->initiative }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding: 12px; background: #f0f4f8; border-radius: 8px; margin-top: 8px;">
                        <span class="text-label-lg" style="color: #003e7e;">Rata-rata (Nilai Akhir)</span>
                        <span class="text-headline-md" style="color: #0058be;">{{ $assessment->final_score }}</span>
                    </div>

                    @if($assessment->notes)
                        <div style="margin-top: 8px;">
                            <span class="text-label-sm" style="color: #737782; display: block; margin-bottom: 4px;">Catatan:</span>
                            <p class="text-body-sm" style="color: #191c20; white-space: pre-wrap;">{{ $assessment->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection
