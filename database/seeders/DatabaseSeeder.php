<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\InternshipPeriod;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Create Roles ──
        $roles = ['admin', 'dosen', 'mahasiswa', 'perusahaan'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // ── Create Companies ──
        $company1 = Company::firstOrCreate(
            ['email' => 'hr@tokopedia.com'],
            [
                'name' => 'PT Tokopedia',
                'address' => 'Tokopedia Tower, Jl. Prof. Dr. Satrio, Jakarta Selatan',
                'phone' => '021-53001000',
                'email' => 'hr@tokopedia.com',
                'website' => 'https://www.tokopedia.com',
                'description' => 'Platform e-commerce terbesar di Indonesia.',
                'contact_person' => 'Budi Setiawan',
            ]
        );

        $company2 = Company::firstOrCreate(
            ['email' => 'hr@gojek.com'],
            [
                'name' => 'PT Gojek Indonesia',
                'address' => 'Pasaraya Blok M, Jl. Iskandarsyah II, Jakarta Selatan',
                'phone' => '021-50251000',
                'email' => 'hr@gojek.com',
                'website' => 'https://www.gojek.com',
                'description' => 'Perusahaan teknologi on-demand multi-layanan.',
                'contact_person' => 'Sari Rahmawati',
            ]
        );

        // ── Create Users ──

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@simagang.test'],
            [
                'name' => 'Admin Prodi',
                'email' => 'admin@simagang.test',
                'password' => Hash::make('password'),
                'faculty' => 'Fakultas Ilmu Komputer',
                'department' => 'Teknik Informatika',
            ]
        );
        $admin->assignRole('admin');

        // Dosen
        $dosen = User::firstOrCreate(
            ['email' => 'dosen@simagang.test'],
            [
                'name' => 'Dr. Ahmad Fauzi, M.Kom.',
                'email' => 'dosen@simagang.test',
                'password' => Hash::make('password'),
                'phone' => '08123456789',
                'faculty' => 'Fakultas Ilmu Komputer',
                'department' => 'Teknik Informatika',
            ]
        );
        $dosen->assignRole('dosen');

        // Mahasiswa 1
        $mhs1 = User::firstOrCreate(
            ['email' => 'mhs1@simagang.test'],
            [
                'name' => 'Budi Pratama',
                'nim' => '2024001001',
                'email' => 'mhs1@simagang.test',
                'password' => Hash::make('password'),
                'phone' => '08211111111',
                'faculty' => 'Fakultas Ilmu Komputer',
                'department' => 'Teknik Informatika',
                'semester' => 6,
            ]
        );
        $mhs1->assignRole('mahasiswa');

        // Mahasiswa 2
        $mhs2 = User::firstOrCreate(
            ['email' => 'mhs2@simagang.test'],
            [
                'name' => 'Siti Aisyah',
                'nim' => '2024001002',
                'email' => 'mhs2@simagang.test',
                'password' => Hash::make('password'),
                'phone' => '08222222222',
                'faculty' => 'Fakultas Ilmu Komputer',
                'department' => 'Sistem Informasi',
                'semester' => 6,
            ]
        );
        $mhs2->assignRole('mahasiswa');

        // Perusahaan User
        $companyUser = User::firstOrCreate(
            ['email' => 'company@simagang.test'],
            [
                'name' => 'HR Tokopedia',
                'email' => 'company@simagang.test',
                'password' => Hash::make('password'),
                'phone' => '02153001000',
                'company_id' => $company1->id,
            ]
        );
        $companyUser->assignRole('perusahaan');

        // ── Create Active Internship Period ──
        InternshipPeriod::firstOrCreate(
            ['name' => 'Semester Genap 2025/2026'],
            [
                'name' => 'Semester Genap 2025/2026',
                'start_date' => '2026-02-01',
                'end_date' => '2026-07-31',
                'is_active' => true,
                'description' => 'Periode magang semester genap tahun akademik 2025/2026.',
            ]
        );

        $this->command->info('✅ Seeder selesai! Akun test:');
        $this->command->table(
            ['Email', 'Password', 'Role'],
            [
                ['admin@simagang.test', 'password', 'admin'],
                ['dosen@simagang.test', 'password', 'dosen'],
                ['mhs1@simagang.test', 'password', 'mahasiswa'],
                ['mhs2@simagang.test', 'password', 'mahasiswa'],
                ['company@simagang.test', 'password', 'perusahaan'],
            ]
        );
    }
}
