<?php

namespace App\Exports;

use App\Models\InternshipApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssessmentExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return InternshipApplication::with(['user', 'company', 'dosen', 'assessments'])
            ->active()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Perusahaan',
            'Dosen Pembimbing',
            'Nilai Dosen',
            'Nilai Perusahaan',
            'Nilai Akhir',
        ];
    }

    public function map($application): array
    {
        $dosenAssessment = $application->assessments->where('assessor_type', 'dosen')->first();
        $perusahaanAssessment = $application->assessments->where('assessor_type', 'perusahaan')->first();

        $dosenScore = $dosenAssessment?->final_score ?? 0;
        $perusahaanScore = $perusahaanAssessment?->final_score ?? 0;

        $finalScore = $application->combined_score ?? 'Belum Lengkap';

        return [
            $application->user->name,
            $application->user->nim,
            $application->company->name,
            $application->dosen->name ?? '-',
            $dosenScore ?: 'Belum Dinilai',
            $perusahaanScore ?: 'Belum Dinilai',
            $finalScore,
        ];
    }
}
