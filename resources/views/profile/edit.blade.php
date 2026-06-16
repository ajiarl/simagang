@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div style="display: grid; grid-template-columns: 3fr 2fr; gap: 24px; align-items: start;">

    {{-- LEFT: Informasi Profil --}}
    <div class="card">
        <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
            <h3 class="text-headline-sm" style="color: #191c20;">Informasi Profil</h3>
            <p class="text-body-sm" style="color: #737782; margin-top: 4px;">Perbarui nama, email, dan informasi kontak Anda.</p>
        </div>
                            <x-form-error name="password_confirmation" />
        <div class="card-body">
            {{-- Avatar + Identity --}}
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid #e2e2e9;; flex-wrap: wrap;">
                <div style="width: 64px; height: 64px; border-radius: 9999px; background: #003e7e; color: #ffffff; font-size: 22px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #c2c6d3;">
                    {{ $user->initials }}
                </div>
                <div>
                    <p class="text-display-sm" style="color: #191c20; margin-bottom: 6px;">{{ $user->name }}</p>
                    <span class="chip-approved" style="background: #d6e3ff; color: #003e7e; padding: 3px 10px; font-size: 12px; font-weight: 600; border-radius: 9999px;">
                        {{ ucfirst($user->getRoleNames()->first() ?? 'User') }}
                    </span>
                </div>
            </div>

            {{-- Profile Form --}}
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="text-label-md" for="name" style="color: #191c20; display: block; margin-bottom: 6px;">
                            Nama Lengkap <span style="color: #ba1a1a;">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="form-input" style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('name') ? '#ba1a1a' : '#c2c6d3' }}; border-radius: 6px; font-size: 15px; color: #191c20; background: #ffffff; box-sizing: border-box;"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="text-label-sm" style="color: #ba1a1a; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="text-label-md" for="email" style="color: #191c20; display: block; margin-bottom: 6px;">
                            Email <span style="color: #ba1a1a;">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('email') ? '#ba1a1a' : '#c2c6d3' }}; border-radius: 6px; font-size: 15px; color: #191c20; background: #ffffff; box-sizing: border-box;"
                            placeholder="email@contoh.com">
                        @error('email')
                            <p class="text-label-sm" style="color: #ba1a1a; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No. Telepon --}}
                    <div>
                        <label class="text-label-md" for="phone" style="color: #191c20; display: block; margin-bottom: 6px;">
                            No. Telepon
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            style="width: 100%; padding: 10px 14px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 15px; color: #191c20; background: #ffffff; box-sizing: border-box;"
                            placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="text-label-sm" style="color: #ba1a1a; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIM (mahasiswa only) --}}
                    @if(auth()->user()->hasRole('mahasiswa'))
                    <div>
                        <label class="text-label-md" for="nim" style="color: #191c20; display: block; margin-bottom: 6px;">
                            NIM
                        </label>
                        <input type="text" id="nim" name="nim" value="{{ old('nim', $user->nim) }}"
                            style="width: 100%; padding: 10px 14px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 15px; color: #191c20; background: #ffffff; box-sizing: border-box;"
                            placeholder="Nomor Induk Mahasiswa">
                        @error('nim')
                            <p class="text-label-sm" style="color: #ba1a1a; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <div style="padding-top: 4px;">
                        <button type="submit" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">save</span>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- RIGHT: Ganti Password + Info Akun --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">

        {{-- Ganti Password --}}
        <div class="card">
            <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
                <h3 class="text-headline-sm" style="color: #191c20;">Ganti Password</h3>
                <p class="text-body-sm" style="color: #737782; margin-top: 4px;">Pastikan password baru minimal 8 karakter.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PATCH')

                    <div style="display: flex; flex-direction: column; gap: 18px;">
                        {{-- Password Lama --}}
                        <div>
                            <label class="text-label-md" for="current_password" style="color: #191c20; display: block; margin-bottom: 6px;">
                                Password Lama <span style="color: #ba1a1a;">*</span>
                            </label>
                            <div style="position: relative;">
                                <input type="password" id="current_password" name="current_password"
                                    style="width: 100%; padding: 10px 40px 10px 14px; border: 1px solid {{ $errors->has('current_password') ? '#ba1a1a' : '#c2c6d3' }}; border-radius: 6px; font-size: 15px; color: #191c20; background: #ffffff; box-sizing: border-box;"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePwd('current_password', this)"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #737782; display: flex;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">visibility</span>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-label-sm" style="color: #ba1a1a; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password Baru --}}
                        <div>
                            <label class="text-label-md" for="password" style="color: #191c20; display: block; margin-bottom: 6px;">
                                Password Baru <span style="color: #ba1a1a;">*</span>
                            </label>
                            <div style="position: relative;">
                                <input type="password" id="password" name="password"
                                    style="width: 100%; padding: 10px 40px 10px 14px; border: 1px solid {{ $errors->has('password') ? '#ba1a1a' : '#c2c6d3' }}; border-radius: 6px; font-size: 15px; color: #191c20; background: #ffffff; box-sizing: border-box;"
                                    placeholder="Min. 8 karakter">
                                <button type="button" onclick="togglePwd('password', this)"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #737782; display: flex;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">visibility</span>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-label-sm" style="color: #ba1a1a; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password Baru --}}
                        <div>
                            <label class="text-label-md" for="password_confirmation" style="color: #191c20; display: block; margin-bottom: 6px;">
                                Konfirmasi Password Baru <span style="color: #ba1a1a;">*</span>
                            </label>
                            <div style="position: relative;">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    style="width: 100%; padding: 10px 40px 10px 14px; border: 1px solid #c2c6d3; border-radius: 6px; font-size: 15px; color: #191c20; background: #ffffff; box-sizing: border-box;"
                                    placeholder="Ulangi password baru">
                                <button type="button" onclick="togglePwd('password_confirmation', this)"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #737782; display: flex;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; width: 100%; justify-content: center;">
                                <span class="material-symbols-outlined" style="font-size: 18px;">lock_reset</span>
                                Simpan Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Informasi Akun --}}
        <div class="card">
            <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3;">
                <h3 class="text-headline-sm" style="color: #191c20;">Informasi Akun</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="text-label-sm" style="color: #737782;">Bergabung sejak</span>
                        <span class="text-body-sm" style="color: #191c20; font-weight: 500;">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div style="border-top: 1px solid #e2e2e9;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="text-label-sm" style="color: #737782;">Status</span>
                        <span class="chip-approved" style="padding: 3px 10px; font-size: 11px;">Aktif</span>
                    </div>
                    <div style="border-top: 1px solid #e2e2e9;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="text-label-sm" style="color: #737782;">Role</span>
                        <span class="text-body-sm" style="color: #191c20; font-weight: 500;">
                            {{ ucfirst($user->getRoleNames()->first() ?? '-') }}
                        </span>
                    </div>
                    @if($user->faculty)
                    <div style="border-top: 1px solid #e2e2e9;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;; flex-wrap: wrap;">
                        <span class="text-label-sm" style="color: #737782; flex-shrink: 0;">Fakultas / Prodi</span>
                        <span class="text-body-sm" style="color: #191c20; font-weight: 500; text-align: right;">
                            {{ $user->department ?? $user->faculty }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @media (max-width: 1023px) {
        div[style*="grid-template-columns: 3fr 2fr"] {
            grid-template-columns: 1fr !important;
        }
    }
    input:focus {
        outline: none;
        border-color: #1a56a0 !important;
        box-shadow: 0 0 0 1px #1a56a0;
    }
</style>

<script>
function togglePwd(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('.material-symbols-outlined');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}
</script>
@endsection
