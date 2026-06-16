@extends('layouts.app')

@section('title', 'Buat Pengajuan Magang')
@section('page-title', 'Pengajuan Magang')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
        <h3 class="text-headline-sm" style="color: #191c20;">Formulir Pengajuan Magang</h3>
        <p class="text-body-sm" style="color: #737782; margin-top: 4px;">Isi data dengan lengkap dan unggah dokumen persyaratan.</p>
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

        <form action="{{ route('mahasiswa.applications.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Periode Magang --}}
            <div style="margin-bottom: 20px;">
                <label for="internship_period_id" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Periode Magang *</label>
                <select name="internship_period_id" id="internship_period_id" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20;" required>
                    <option value="">-- Pilih Periode --</option>
                    @foreach($activePeriods as $period)
                        <option value="{{ $period->id }}" {{ old('internship_period_id') == $period->id ? 'selected' : '' }}>
                            {{ $period->name }} ({{ $period->start_date->format('M Y') }} - {{ $period->end_date->format('M Y') }})
                        </option>
                    @endforeach
                </select>
                <x-form-error name="internship_period_id" />
            </div>

            {{-- Perusahaan Mitra --}}
            <div style="margin-bottom: 20px;">
                <label for="company_id" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Perusahaan Tujuan *</label>
                <select name="company_id" id="company_id" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20;" required>
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }} - {{ $company->city }}
                        </option>
                    @endforeach
                </select>
                <x-form-error name="company_id" />
            </div>

            {{-- Motivasi / Tujuan --}}
            <div style="margin-bottom: 24px;">
                <label for="motivation" style="display: block; font-weight: 500; margin-bottom: 8px; color: #191c20;">Motivasi / Tujuan Magang *</label>
                <textarea name="motivation" id="motivation" rows="4" style="width: 100%; padding: 10px 12px; border: 1px solid #c2c6d3; border-radius: 8px; font-size: 14px; color: #191c20; resize: vertical;" required placeholder="Jelaskan alasan Anda memilih perusahaan ini dan apa yang ingin Anda capai...">{{ old('motivation') }}</textarea>
                <x-form-error name="motivation" />
            </div>

            <div style="margin-bottom: 24px; padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                <h4 style="font-weight: 600; color: #191c20; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;; flex-wrap: wrap;">
                    <span class="material-symbols-outlined" style="font-size: 20px; color: #0058be;">upload_file</span> Dokumen Persyaratan
                </h4>
                
                {{-- KTM --}}
                <div style="margin-bottom: 16px;">
                    <label for="ktm_file" style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; color: #191c20;">Kartu Tanda Mahasiswa (KTM) *</label>
                    <input type="file" name="ktm_file" id="ktm_file" accept=".pdf,.jpg,.jpeg,.png" style="width: 100%; font-size: 14px; color: #424751;" required>
                    <x-form-error name="ktm_file" />
                    <p style="font-size: 12px; color: #737782; margin-top: 4px;">Format: PDF/JPG/PNG. Maksimal 2MB.</p>
                </div>

                {{-- Surat Permohonan --}}
                <div>
                    <label for="surat_permohonan" style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; color: #191c20;">Surat Permohonan dari Fakultas *</label>
                    <input type="file" name="surat_permohonan" id="surat_permohonan" accept=".pdf" style="width: 100%; font-size: 14px; color: #424751;" required>
                    <x-form-error name="surat_permohonan" />
                    <p style="font-size: 12px; color: #737782; margin-top: 4px;">Format: PDF. Maksimal 5MB.</p>
                </div>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #c2c6d3; padding-top: 20px;; flex-wrap: wrap;">
                <a href="{{ route('mahasiswa.applications.index') }}" class="btn-secondary" style="text-decoration: none;">Batal</a>
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-outlined" style="font-size: 18px;">send</span> Ajukan Magang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
