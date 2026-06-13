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
            ->whereIn('status', ['approved', 'completed'])
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
        $totalLogbook = $application->logbooks->count();
        $approvedLogbook = $application->logbooks->where('status', 'approved')->count();
        $pendingLogbook = $application->logbooks->where('status', 'submitted')->count();
        $rejectedLogbook = $application->logbooks->where('status', 'rejected')->count();

        // Attendance stats
        $totalAttendance = $application->attendances->count();
        $presentCount = $application->attendances->where('status', 'present')->count();
        $sickCount = $application->attendances->where('status', 'sick')->count();
        $permitCount = $application->attendances->where('status', 'permit')->count();
        $alphaCount = $application->attendances->where('status', 'absent')->count();

        // Get assessments
        $dosenAssessment = $application->assessments->where('assessor_type', 'dosen')->first();
        $companyAssessment = $application->assessments->where('assessor_type', 'perusahaan')->first();

        return view('dosen.students.show', compact(
            'application',
            'totalLogbook',
            'approvedLogbook',
            'pendingLogbook',
            'rejectedLogbook',
            'totalAttendance',
            'presentCount',
            'sickCount',
            'permitCount',
            'alphaCount',
            'dosenAssessment',
            'companyAssessment'
        ));
    }
}
