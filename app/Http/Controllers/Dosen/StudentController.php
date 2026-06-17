<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $applications = InternshipApplication::with(['user', 'company', 'internshipPeriod'])
            ->where('dosen_id', auth()->id())
            ->active()
            ->get();

        return view('dosen.students.index', compact('applications'));
    }

    public function show(InternshipApplication $application)
    {
        // Security check
        if ($application->dosen_id !== auth()->id()) {
            abort(403);
        }

        $application->load(['user', 'company', 'internshipPeriod', 'logbooks', 'attendances', 'assessments']);

        // Calculate logbook stats
        $totalLogbook    = $application->logbooks->count();
        $approvedLogbook = $application->logbooks->where('status', 'approved')->count();
        $pendingLogbook  = $application->logbooks->where('status', 'submitted')->count();
        $rejectedLogbook = $application->logbooks->where('status', 'rejected')->count();

        // Attendance stats — "hadir" = verified_at is set (QR scanned by company)
        $totalAttendance = $application->attendances->count();
        $verifiedCount   = $application->attendances->whereNotNull('verified_at')->count();
        $pendingCount    = $application->attendances->whereNull('verified_at')->count();

        // Get assessments
        $dosenAssessment   = $application->assessments->where('assessor_type', 'dosen')->first();
        $companyAssessment = $application->assessments->where('assessor_type', 'perusahaan')->first();

        return view('dosen.students.show', compact(
            'application',
            'totalLogbook',
            'approvedLogbook',
            'pendingLogbook',
            'rejectedLogbook',
            'totalAttendance',
            'verifiedCount',
            'pendingCount',
            'dosenAssessment',
            'companyAssessment'
        ));
    }
}
