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
            'Total Hadir',
            'Total Izin',
            'Total Sakit',
            'Total Alpa (Tanpa Keterangan)',
        ];
    }

    public function map($application): array
    {
        $attendances = $application->attendances;

        return [
            $application->user->name,
            $application->user->nim,
            $application->company->name,
            $attendances->where('status', 'present')->count(),
            $attendances->where('status', 'permit')->count(),
            $attendances->where('status', 'sick')->count(),
            $attendances->where('status', 'absent')->count(),
        ];
    }
}
