<?php

namespace App\Exports;

use App\Models\InternshipApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return InternshipApplication::with(['user', 'company', 'attendances'])
            ->whereIn('status', ['approved', 'completed'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Perusahaan',
            'Hadir (Terverifikasi)',
            'Belum Diverifikasi',
        ];
    }

    public function map($application): array
    {
        $attendances = $application->attendances;

        return [
            $application->user->name,
            $application->user->nim,
            $application->company->name,
            $attendances->whereNotNull('verified_at')->count(),
            $attendances->whereNull('verified_at')->count(),
        ];
    }
}
