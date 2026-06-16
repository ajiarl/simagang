<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get the active approved application with its assessments (also show for completed)
        $application = InternshipApplication::with('assessments')
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved', 'completed'])
            ->latest()
            ->first();

        if (!$application) {
            return view('mahasiswa.assessments.index', [
                'hasApplication' => false,
                'dosenAssessment' => null,
                'perusahaanAssessment' => null,
                'combinedScore' => null,
            ]);
        }

        $dosenAssessment = $application->assessments->where('assessor_type', 'dosen')->first();
        $perusahaanAssessment = $application->assessments->where('assessor_type', 'perusahaan')->first();

        $dosenScore = $dosenAssessment?->final_score;
        $perusahaanScore = $perusahaanAssessment?->final_score;

        $combinedScore = ($dosenScore && $perusahaanScore)
            ? round(($dosenScore + $perusahaanScore) / 2, 2)
            : null;

        return view('mahasiswa.assessments.index', [
            'hasApplication' => true,
            'application' => $application,
            'dosenAssessment' => $dosenAssessment,
            'perusahaanAssessment' => $perusahaanAssessment,
            'combinedScore' => $combinedScore,
        ]);
    }
}
