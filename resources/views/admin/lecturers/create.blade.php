@extends('layouts.app')

@section('title', 'Tambah Dosen Pembimbing')
@section('page-title', 'Tambah Dosen')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('admin.lecturers.index') }}" class="btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span> Kembali ke Daftar
    </a>
</div>

<div class="card max-w-2xl">
    <div style="padding: 20px 24px; border-bottom: 1px solid #e2e2e9;">
        <h3 class="text-headline-sm" style="color: #191c20; margin: 0;">Form Tambah Dosen Pembimbing</h3>
    </div>
    
    <div style="padding: 24px;">
        <form method="POST" action="{{ route('admin.lecturers.store') }}" style="display: flex; flex-direction: column; gap: 24px;">
            @csrf
            
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="name" class="text-label-md" style="color: #424751; font-weight: 600;">Nama Lengkap (beserta gelar) <span style="color: #ba1a1a;">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input" style="width: 100%; padding: 10px 16px; border-radius: 6px; border: 1px solid #c2c6d3;" placeholder="Contoh: Dr. Ahmad Fauzi, M.Kom.">
                <x-form-error name="name" />
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="email" class="text-label-md" style="color: #424751; font-weight: 600;">Email <span style="color: #ba1a1a;">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input" style="width: 100%; padding: 10px 16px; border-radius: 6px; border: 1px solid #c2c6d3;" placeholder="email@contoh.com">
                <x-form-error name="email" />
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="phone" class="text-label-md" style="color: #424751; font-weight: 600;">No. Telepon (Opsional)</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-input" style="width: 100%; padding: 10px 16px; border-radius: 6px; border: 1px solid #c2c6d3;" placeholder="Contoh: 08123456789">
                <x-form-error name="phone" />
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="faculty" class="text-label-md" style="color: #424751; font-weight: 600;">Fakultas (Opsional)</label>
                <input type="text" id="faculty" name="faculty" value="{{ old('faculty') }}" class="form-input" style="width: 100%; padding: 10px 16px; border-radius: 6px; border: 1px solid #c2c6d3;" placeholder="Contoh: Fakultas Ilmu Komputer">
                <x-form-error name="faculty" />
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="department" class="text-label-md" style="color: #424751; font-weight: 600;">Departemen / Program Studi (Opsional)</label>
                <input type="text" id="department" name="department" value="{{ old('department') }}" class="form-input" style="width: 100%; padding: 10px 16px; border-radius: 6px; border: 1px solid #c2c6d3;" placeholder="Contoh: Teknik Informatika">
                <x-form-error name="department" />
            </div>
            
            <hr style="border: 0; border-top: 1px solid #e2e2e9; margin: 8px 0;">
            <h4 class="text-label-lg" style="color: #191c20; margin: 0; font-weight: 600;">Keamanan</h4>
            
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="password" class="text-label-md" style="color: #424751; font-weight: 600;">Password <span style="color: #ba1a1a;">*</span></label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" required class="form-input" style="width: 100%; padding: 10px 16px; padding-right: 48px; border-radius: 6px; border: 1px solid #c2c6d3;" placeholder="Minimal 8 karakter">
                    <button type="button" onclick="togglePassword('password', 'eyeIcon1')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #737782; display: flex; align-items: center; padding: 4px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;" id="eyeIcon1">visibility_off</span>
                    </button>
                </div>
                <x-form-error name="password" />
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="password_confirmation" class="text-label-md" style="color: #424751; font-weight: 600;">Konfirmasi Password <span style="color: #ba1a1a;">*</span></label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-input" style="width: 100%; padding: 10px 16px; padding-right: 48px; border-radius: 6px; border: 1px solid #c2c6d3;" placeholder="Ketik ulang password">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #737782; display: flex; align-items: center; padding: 4px;">
                        <span class="material-symbols-outlined" style="font-size: 20px;" id="eyeIcon2">visibility_off</span>
                    </button>
                </div>
                <x-form-error name="password_confirmation" />
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 16px;">
                <a href="{{ route('admin.lecturers.index') }}" class="btn-secondary" style="text-decoration: none; padding: 10px 16px;">Batal</a>
                <button type="submit" id="submitBtn" class="btn-primary" style="padding: 10px 16px;"
                    onclick="this.disabled=true; this.querySelector('.btn-text').textContent='Menyimpan...'; this.form.submit();">
                    <span class="material-symbols-outlined" style="font-size: 18px; margin-right: 6px;">save</span>
                    <span class="btn-text">Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility_off';
        }
    }
</script>
@endsection
